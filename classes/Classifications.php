<?php

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
    $records = Classifications::readByRecords($this->getFilePath('classifications-by-records.csv'), $this->count);

    $smarty->assign('count', $this->count);
    $smarty->assign('withClassification', $records->withClassification);
    $smarty->assign('withoutClassification', $records->withoutClassification);
  }

  public static function readByRecords($filepath, $total) {
    $records = [];
    if (file_exists($filepath)) {
      $header = [];
      $in = fopen($filepath, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $record->percent = $record->count / $total;
          if ($record->{'records-with-classification'} === 'true') {
            $records["withClassification"] = $record;
          } else {
            $records["withoutClassification"] = $record;
          }
        }
      }
      return (object)$records;
    }
  }

  private function readByField(Smarty &$smarty) {
    $solrFields = $this->solr()->getSolrFields(); // $this->id
    SchemaUtil::initializeSchema($this->catalogue->getSchemaType());

    if ($this->catalogue->getSchemaType() == 'MARC21') {
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
    } elseif ($this->catalogue->getSchemaType() == 'PICA') {
      $schema = new Pica\PicaSchemaManager();
      $fields = $this->readPicaSubjectFieldsFromFile();
      if (empty($fields)) {
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
      }
      $picaFields = array_keys($fields);
    }

    $solrFieldMap = $this->getSolrFieldMap();

    $byRecordsFile = $this->getFilePath('classifications-by-schema.csv');
    if (!file_exists($byRecordsFile)) {
      $byRecordsFile = $this->getFilePath('classifications-by-field.csv');
    }
    if (file_exists($byRecordsFile)) {
      error_log('classification file: ' . $byRecordsFile);
      $header = [];
      $records = [];
      $in = fopen($byRecordsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);

          if ($record->field == '052') {
            $this->createFacets($record, '052a_GeographicClassification');
            $this->ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          } else if ($record->field == '055') {
            $this->createFacets($record, '055a_ClassificationLcc');
            $this->ind2Orsubfield2($record, '055ind2_ClassificationLcc_type_ss', '0552_ClassificationLcc_source_ss');
          } else if ($record->field == '072') {
            $this->createFacets($record, '072a_SubjectCategoryCode');
            $this->ind2Orsubfield2($record, '072ind2_SubjectCategoryCode_codeSource_ss', '0722_SubjectCategoryCode_source_ss');
          } else if ($record->field == '080') {
            $record->facet = $solrFieldMap[$record->field . str_replace('$', '', $record->location)]; // '080a_Udc_ss';
            $record->q = '*:*';
          } else if ($record->field == '082') {
            $record->facet = $solrFieldMap[$record->field . str_replace('$', '', $record->location)]; // '082a_ClassificationDdc_ss';
            $record->q = '*:*';
          } else if ($record->field == '083') {
            $record->facet = $solrFieldMap[$record->field . str_replace('$', '', $record->location)]; // '083a_ClassificationAdditionalDdc_ss';
            $record->q = '*:*';
          } else if ($record->field == '084') {
            $this->createFacets($record, '084a_Classification_classificationPortion');
            $record->q = urlencode(sprintf('%s:"%s"', '0842_Classification_source_ss', $record->scheme));
          } else if ($record->field == '085') {
            $record->facet = $solrFieldMap[$record->field . str_replace('$', '', $record->location)]; // '085b_SynthesizedClassificationNumber_baseNumber_ss';
            $record->q = '*:*';
          } else if ($record->field == '086') {
            $this->createFacets($record, '086a_GovernmentDocumentClassification');
            $this->ind1Orsubfield2($record, '086ind1_GovernmentDocumentClassification_numberSource_ss', '0862_GovernmentDocumentClassification_source_ss');
          } else if ($record->field == '600') {
            $this->createFacets($record, '600a_PersonalNameSubject_personalName');
            $this->ind2Orsubfield2($record, '600ind2_PersonalNameSubject_thesaurus_ss', '6002_PersonalNameSubject_source_ss');
          } else if ($record->field == '610') {
            $this->createFacets($record, '610a_CorporateNameSubject');
            $this->ind2Orsubfield2($record, '610ind2_CorporateNameSubject_thesaurus_ss', '6102_CorporateNameSubject_source_ss');
          } else if ($record->field == '611') {
            $this->createFacets($record, '611a_SubjectAddedMeetingName');
            $this->ind2Orsubfield2($record, '611ind2_SubjectAddedMeetingName_thesaurus_ss', '6112_SubjectAddedMeetingName_source_ss');
          } else if ($record->field == '630') {
            $this->createFacets($record, '630a_SubjectAddedUniformTitle');
            $this->ind2Orsubfield2($record, '630ind2_SubjectAddedUniformTitle_thesaurus_ss', '6302_SubjectAddedUniformTitle_source_ss');
            // TODO: 647
          } else if ($record->field == '648') {
            $this->createFacets($record, '648a_ChronologicalSubject');
            $this->ind2Orsubfield2($record, '648ind2_ChronologicalSubject_thesaurus_ss', '6482_ChronologicalSubject_source_ss');
          } else if ($record->field == '650') {
            $this->createFacets($record, '650a_Topic_topicalTerm');
            $this->ind2Orsubfield2($record, '650ind2_Topic_thesaurus_ss', '6502_Topic_sourceOfHeading_ss');
          } else if ($record->field == '651') {
            $this->createFacets($record, '651a_Geographic');
            $this->ind2Orsubfield2($record, '651ind2_Geographic_thesaurus_ss', '6512_Geographic_source_ss');
          } else if ($record->field == '653') {
            $this->createFacets($record, '653a_UncontrolledIndexTerm');
            $record->q = urlencode(sprintf('653ind2_UncontrolledIndexTerm_type_ss:"%s"', $record->scheme));
          } else if ($record->field == '655') {
            $this->createFacets($record, '655a_GenreForm');
            $this->ind2Orsubfield2($record, '655ind2_GenreForm_thesaurus_ss', '6552_GenreForm_source_ss');
          } else if ($record->field == '658') {
            $this->createFacets($record, '658a_CurriculumObjective_main');
            $this->subfield0or2($record, 'CurriculumObjective');
          } else if ($record->field == '662') {
            $this->createFacets($record, '662a_HierarchicalGeographic_country');
            $this->subfield0or2($record, 'HierarchicalGeographic');
          } else if ($record->field == '852') {
            $this->createFacets($record, '852a_Location_location');
            $this->ind1Orsubfield2($record, '852ind1_852_shelvingScheme_ss', '852__852___ss');
          } else if ($this->catalogue->getSchemaType() == 'PICA'
                     && in_array($record->field, $picaFields)) {
            $record->facet = $this->picaToSolr($record->field) . '_full_ss';
            $record->facet2 = $record->facet; // . '_full_ss';

            $definition = SchemaUtil::getDefinition($record->field);
            $pica3 = ($definition != null && isset($definition->pica3) ? '=' . $definition->pica3 : '');
            $record->withPica3 = $record->field . $pica3;
          } else if ($this->catalogue->getSchemaType() == 'PICA'
                    && in_array($record->field, ['044A', '044C', '044H', '044N', '044S', '045A', '045B', '045F', '045N', '045N/01', '045N/02', '045R', '045C', '045E', '045G'])
                    || preg_match('/^(045B|144Z|145S)/', $record->field)) {
            $record->facet = $this->picaToSolr($record->field) . '_full_ss';
            $record->facet2 = $record->facet; // . '_full_ss';

            $definition = SchemaUtil::getDefinition($record->field);
            $pica3 = ($definition != null && isset($definition->pica3) ? '=' . $definition->pica3 : '');
            $record->withPica3 = $record->field . $pica3;
          } else {
            error_log('unhandled field in classification: ' . $record->field);
          }

          if (isset($record->facet2) && $record->facet2 != '') {
            $record->facet2exists = in_array($record->facet2, $solrFields);
            if (!$record->facet2exists)
              error_log($record->facet2 . ' is not existing');
          }

          if (preg_match('/(^ |  +| $)/', $record->scheme))
            $record->scheme = '"' . str_replace(' ', '&nbsp;', $record->scheme) . '"';

          $record->ratio = $record->recordcount / $this->count;
          $record->percent = $record->ratio * 100;

          $records[] = $record;
        }
      }

      $smarty->assign('records', $records);
      $smarty->assign('fields', $fields);

      $this->readClassificationSubfields($smarty);
      $this->readElements($smarty);
    }
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

    /**
   * @param Smarty $smarty
   * @return object
   */
  private function readClassificationSubfields(Smarty &$smarty) {
    $bySubfieldsFile = $this->getFilePath('classifications-by-schema-subfields.csv');
    $this->readSubfields($smarty, $bySubfieldsFile);
  }

  private function readPicaSubjectFieldsFromFile() :array {
    $subjectsFile = $this->getFilePath('k10plus-subjects.tsv');
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
}
