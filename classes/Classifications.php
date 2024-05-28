<?php

use Schema\Pica\PicaSchemaManager;

class Classifications extends AddedEntry {

  protected $frequencyExamples;
  protected $parameterFile = 'classifications.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->loadByRecords($smarty);
    $this->readByField($smarty);
    $this->readFrequencyExamples($smarty);
  }

  public function getTemplate() {
    return 'classifications/classifications.tpl';
  }

  private function loadByRecords(Smarty &$smarty) {
    $classificationRecords = Classifications::readByRecords($this->getFilePath('classifications-by-records.csv'), $this->count);

    $smarty->assign('count', $this->count);
    $smarty->assign('withClassification', $classificationRecords->withClassification);

    $smarty->assign('withoutClassification', $classificationRecords->withoutClassification);
  }

  public static function readByRecords($filepath, $total) {
    $classificationRecords = [];
    if (!file_exists($filepath)) {
      return (object)$classificationRecords;
    }

    $header = [];
    $in = fopen($filepath, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
        continue;
      }

      $classificationRecord = (object)array_combine($header, $values);
      $classificationRecord->percent = $classificationRecord->count / $total;
      if ($classificationRecord->{'records-with-classification'} === 'true') {
        $classificationRecords["withClassification"] = $classificationRecord;
      } else {
        $classificationRecords["withoutClassification"] = $classificationRecord;
      }

    }
    return (object)$classificationRecords;
  }

  private function readByField(Smarty &$smarty) {
    $solrFields = $this->solr()->getSolrFields(); // $this->id
    SchemaUtil::initializeSchema($this->catalogue->getSchemaType());
    // Define the fields variable
    if ($this->catalogue->getSchemaType() == 'MARC21') {
      $fields = $this->getMarc21PredefinedSubjectFields();
    } elseif ($this->catalogue->getSchemaType() == 'PICA') {
      $fields = $this->readPicaSubjectFieldsFromFile();
      if (empty($fields)) {
        $fields = $this->getPicaPredefinedSubjectFields();
      }
      $picaFields = array_keys($fields);
    } elseif ($this->catalogue->getSchemaType() == 'UNIMARC') {
      $fieldList = ["600", "601", "602", "604", "605", "606",
        "607", "608", "610", "615", "616", "617", "620", "621", "623", "626", "631", "632", "660", "661", "670", "675",
        "676", "680", "686"];

      // Get the field labels from the UNIMARC schema
      foreach ($fieldList as $field) {
        $fields[$field] = SchemaUtil::getDefinition($field)->label;
      }
    }

    $solrFieldMap = $this->getSolrFieldMap();

    $byRecordsFile = $this->getFilePath('classifications-by-schema.csv');
    if (!file_exists($byRecordsFile)) {
      $byRecordsFile = $this->getFilePath('classifications-by-field.csv');
    }
    if (!file_exists($byRecordsFile)) {
      return;
    }
    
    error_log('classification file: ' . $byRecordsFile);
    $header = [];
    $classificationRecords = [];
    $in = fopen($byRecordsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
        continue;
      }
      $classificationRecord = (object)array_combine($header, $values);
      if ($this->catalogue->getSchemaType() == 'MARC21') {
        $this->createFacetForMarc21($classificationRecord, $solrFieldMap);
      } elseif ($this->catalogue->getSchemaType() == 'PICA') {
        $this->createFacetForPica($classificationRecord, $picaFields);
      } elseif ($this->catalogue->getSchemaType() == 'UNIMARC') {
        $this->setUnimarcFacets($classificationRecord);
      } else {
        error_log('unhandled field in classification: ' . $classificationRecord->field);
      }
      if (isset($classificationRecord->facet2) && $classificationRecord->facet2 != '') {
        $classificationRecord->facet2exists = in_array($classificationRecord->facet2, $solrFields);
        if (!$classificationRecord->facet2exists) {
          error_log($classificationRecord->facet2 . ' is not existing');
        }
      }
      if (preg_match('/(^ |  +| $)/', $classificationRecord->scheme)) {
        $classificationRecord->scheme = '"' . str_replace(' ', '&nbsp;', $classificationRecord->scheme) . '"';
      }
      $classificationRecord->ratio = $classificationRecord->recordcount / $this->count;
      $classificationRecord->percent = $classificationRecord->ratio * 100;

      $classificationRecords[] = $classificationRecord;
    }

    $smarty->assign('records', $classificationRecords);
    $smarty->assign('fields', $fields);

    $this->readClassificationSubfields($smarty);
    $this->readElements($smarty);
  }

  private function readFrequencyExamples(Smarty &$smarty) {
    $file = $this->getFilePath('classifications-frequency-examples.csv');
    if (file_exists($file)) {
      $frequencyExamples = readCsv($file);
      $examples = [];
      foreach ($frequencyExamples as $example) {
        $examples[$example->count] = $example->id;
      }
      $smarty->assign('frequencyExamples', $examples);
    }
  }

  private function readClassificationSubfields(Smarty &$smarty): void {
    $bySubfieldsFile = $this->getFilePath('classifications-by-schema-subfields.csv');
    $this->readSubfields($smarty, $bySubfieldsFile);
  }

  private function readPicaSubjectFieldsFromFile(): array {
    $classificationSchemaFile = $this->analysisParameters->classificationSchemaFile ?? 'k10plus-subjects.tsv';
    $subjectsFile = $this->getFilePath($classificationSchemaFile);
    $fields = [];
    if (file_exists($subjectsFile)) {
      $in = fopen($subjectsFile, "r");
      while (($line = fgets($in)) != false) {
        $parts = explode("\t", $line);
        $tag = $parts[0];
        if ($parts[1] != '')
          $tag .= '/' . $parts[1];
        $fields[$tag] = $parts[2];
      }
      fclose($in);
    }
    return $fields;
  }

  /**
   * @return string[]
   */
  protected function getPicaPredefinedSubjectFields(): array {
    $fields = [
      "045A" => "LCC-Notation",
      "045F" => "DDC-Notation",
      "045R" => "Regensburger Verbundklassifikation (RVK)",
      "045B" => "Allgemeine Systematik für Bibliotheken (ASB)",
      "045B/00" => "Allgemeine Systematik für Bibliotheken (ASB)",
      "045B/01" => "Systematik der Stadtbibliothek Duisburg (SSD)",
      "045B/02" => "Systematik für Bibliotheken (SfB)",
      "045B/03" => "Klassifikation für Allgemeinbibliotheken (KAB)",
      "045B/04" => "Systematiken der ekz",
      "045B/05" => "Gattungsbegriffe (DNB)",
      "045C" => "Notation – Beziehung",
      "045E" => "Sachgruppen der Deutschen Nationalbibliografie bis 2003",
      "045G" => "Sachgruppen der Deutschen Nationalbibliografie ab 2004",
      "041A" => "Sachbegriff - Bevorzugte Benennung",
      "144Z/00-99" => "Lokale Schlagwörter",
      "145S/00-99" => "Lesesaalsystematik der SBB"
    ];
    return $fields;
  }

  private function setUnimarcFacets($classificationRecord) {
    // Fields 675, 676, and 677 have no specific queries
    if (in_array($classificationRecord->field, ['675', '676', '677'])) {
      $classificationRecord->facet = $classificationRecord->field . 'a_ss';
      $classificationRecord->q = '*:*';
      return;
    }

    // Create facets for the UNIMARC schema in a sense that the facet is field with the subfield $a
    // and the facet2 attribute is set only if there's a detected schema abbreviation
    $this->createFacets($classificationRecord, $classificationRecord->field . 'a');

    // Similarly to MARC21, but uniformly for all fields in UNIMARC, the source is specified only in the subfield $2
    $subfield2 = $classificationRecord->field . '2_ss';
    if ($classificationRecord->scheme == 'undetectable') {
      $classificationRecord->q = sprintf('%s:* NOT %s:*', $classificationRecord->facet, $subfield2);
    } else {
      $classificationRecord->q = sprintf('%s:%%22%s%%22', $subfield2, urlencode($classificationRecord->abbreviation));
    }
  }


  /**
   * @return string[]
   */
  protected function getMarc21PredefinedSubjectFields(): array
  {
    $fields = [
      '052' => 'Geographic Classification',
      '055' => 'Classification Numbers Assigned in Canada',
      '072' => 'Subject Category Code',
      '080' => 'Universal Decimal Classification Number',
      '082' => 'Dewey Decimal Classification Number',
      '083' => 'Additional Dewey Decimal Classification Number',
      '084' => 'Other Classification Number',
      '085' => 'Synthesized Classification Number Components',
      '086' => 'Government Document Classification Number',
      '600' => 'Subject Added Entry - Personal Name',
      '610' => 'Subject Added Entry - Corporate Name',
      '611' => 'Subject Added Entry - Meeting Name',
      '630' => 'Subject Added Entry - Uniform Title',
      '647' => 'Subject Added Entry - Named Event',
      '648' => 'Subject Added Entry - Chronological Term',
      '650' => 'Subject Added Entry - Topical Term',
      '651' => 'Subject Added Entry - Geographic Name',
      '654' => 'Subject Added Entry - Faceted Topical Terms',
      '653' => 'Index Term - Uncontrolled',
      '655' => 'Index Term - Genre/Form',
      '656' => 'Index Term - Occupation',
      '657' => 'Index Term - Function',
      '658' => 'Index Term - Curriculum Objective',
      '662' => 'Subject Added Entry - Hierarchical Place Name',
      '852' => 'Location',
    ];
    return $fields;
  }

  /**
   * @param object $classificationRecord
   * @param array $solrFieldMap
   * @return object
   */
  protected function createFacetForMarc21(object $classificationRecord, array $solrFieldMap): object
  {
    if ($classificationRecord->field == '052') {
      $this->createFacets($classificationRecord, '052a_GeographicClassification');
      $this->ind1Orsubfield2($classificationRecord, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
    } elseif ($classificationRecord->field == '055') {
      $this->createFacets($classificationRecord, '055a_ClassificationLcc');
      $this->ind2Orsubfield2($classificationRecord, '055ind2_ClassificationLcc_type_ss', '0552_ClassificationLcc_source_ss');
    } elseif ($classificationRecord->field == '072') {
      $this->createFacets($classificationRecord, '072a_SubjectCategoryCode');
      $this->ind2Orsubfield2($classificationRecord, '072ind2_SubjectCategoryCode_codeSource_ss', '0722_SubjectCategoryCode_source_ss');
    } elseif ($classificationRecord->field == '080') {
      $classificationRecord->facet = $solrFieldMap[$classificationRecord->field . str_replace('$', '', $classificationRecord->location)]; // '080a_Udc_ss';
      $classificationRecord->q = '*:*';
    } elseif ($classificationRecord->field == '082') {
      $classificationRecord->facet = $solrFieldMap[$classificationRecord->field . str_replace('$', '', $classificationRecord->location)]; // '082a_ClassificationDdc_ss';
      $classificationRecord->q = '*:*';
    } elseif ($classificationRecord->field == '083') {
      $classificationRecord->facet = $solrFieldMap[$classificationRecord->field . str_replace('$', '', $classificationRecord->location)]; // '083a_ClassificationAdditionalDdc_ss';
      $classificationRecord->q = '*:*';
    } elseif ($classificationRecord->field == '084') {
      $this->createFacets($classificationRecord, '084a_Classification_classificationPortion');
      $classificationRecord->q = urlencode(sprintf('%s:"%s"', '0842_Classification_source_ss', $classificationRecord->scheme));
    } elseif ($classificationRecord->field == '085') {
      $classificationRecord->facet = $solrFieldMap[$classificationRecord->field . str_replace('$', '', $classificationRecord->location)]; // '085b_SynthesizedClassificationNumber_baseNumber_ss';
      $classificationRecord->q = '*:*';
    } elseif ($classificationRecord->field == '086') {
      $this->createFacets($classificationRecord, '086a_GovernmentDocumentClassification');
      $this->ind1Orsubfield2($classificationRecord, '086ind1_GovernmentDocumentClassification_numberSource_ss', '0862_GovernmentDocumentClassification_source_ss');
    } elseif ($classificationRecord->field == '600') {
      $this->createFacets($classificationRecord, '600a_PersonalNameSubject_personalName');
      $this->ind2Orsubfield2($classificationRecord, '600ind2_PersonalNameSubject_thesaurus_ss', '6002_PersonalNameSubject_source_ss');
    } elseif ($classificationRecord->field == '610') {
      $this->createFacets($classificationRecord, '610a_CorporateNameSubject');
      $this->ind2Orsubfield2($classificationRecord, '610ind2_CorporateNameSubject_thesaurus_ss', '6102_CorporateNameSubject_source_ss');
    } elseif ($classificationRecord->field == '611') {
      $this->createFacets($classificationRecord, '611a_SubjectAddedMeetingName');
      $this->ind2Orsubfield2($classificationRecord, '611ind2_SubjectAddedMeetingName_thesaurus_ss', '6112_SubjectAddedMeetingName_source_ss');
    } elseif ($classificationRecord->field == '630') {
      $this->createFacets($classificationRecord, '630a_SubjectAddedUniformTitle');
      $this->ind2Orsubfield2($classificationRecord, '630ind2_SubjectAddedUniformTitle_thesaurus_ss', '6302_SubjectAddedUniformTitle_source_ss');
      // TODO: 647
    } elseif ($classificationRecord->field == '648') {
      $this->createFacets($classificationRecord, '648a_ChronologicalSubject');
      $this->ind2Orsubfield2($classificationRecord, '648ind2_ChronologicalSubject_thesaurus_ss', '6482_ChronologicalSubject_source_ss');
    } elseif ($classificationRecord->field == '650') {
      $this->createFacets($classificationRecord, '650a_Topic_topicalTerm');
      $this->ind2Orsubfield2($classificationRecord, '650ind2_Topic_thesaurus_ss', '6502_Topic_sourceOfHeading_ss');
    } elseif ($classificationRecord->field == '651') {
      $this->createFacets($classificationRecord, '651a_Geographic');
      $this->ind2Orsubfield2($classificationRecord, '651ind2_Geographic_thesaurus_ss', '6512_Geographic_source_ss');
    } elseif ($classificationRecord->field == '653') {
      $this->createFacets($classificationRecord, '653a_UncontrolledIndexTerm');
      $classificationRecord->q = urlencode(sprintf('653ind2_UncontrolledIndexTerm_type_ss:"%s"', $classificationRecord->scheme));
    } elseif ($classificationRecord->field == '655') {
      $this->createFacets($classificationRecord, '655a_GenreForm');
      $this->ind2Orsubfield2($classificationRecord, '655ind2_GenreForm_thesaurus_ss', '6552_GenreForm_source_ss');
    } elseif ($classificationRecord->field == '658') {
      $this->createFacets($classificationRecord, '658a_CurriculumObjective_main');
      $this->subfield0or2($classificationRecord, 'CurriculumObjective');
    } elseif ($classificationRecord->field == '662') {
      $this->createFacets($classificationRecord, '662a_HierarchicalGeographic_country');
      $this->subfield0or2($classificationRecord, 'HierarchicalGeographic');
    } elseif ($classificationRecord->field == '852') {
      $this->createFacets($classificationRecord, '852a_Location_location');
      $this->ind1Orsubfield2($classificationRecord, '852ind1_852_shelvingScheme_ss', '852__852___ss');
    } else {
      error_log('unhandled field in classification: ' . $classificationRecord->field);
    }
    return $classificationRecord;
  }

  /**
   * @param object $classificationRecord
   * @param array $picaFields
   * @return void
   */
  protected function createFacetForPica(object $classificationRecord, array $picaFields): void
  {
    if (!in_array($classificationRecord->field, $picaFields)) {
      error_log('unhandled field in classification: ' . $classificationRecord->field);
      return;
    }
    $classificationRecord->facet = $this->picaToSolr($classificationRecord->field) . '_full_ss';
    $classificationRecord->facet2 = $classificationRecord->facet; // . '_full_ss';
    $definition = SchemaUtil::getDefinition($classificationRecord->field);
    $pica3 = ($definition != null && isset($definition->pica3) ? '=' . $definition->pica3 : '');
    $classificationRecord->withPica3 = $classificationRecord->field . $pica3;
  }
}
