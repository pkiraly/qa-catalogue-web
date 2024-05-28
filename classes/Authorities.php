<?php

class Authorities extends AddedEntry {

  protected $parameterFile = 'authorities.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->loadByRecords($smarty);
    $this->readByField($smarty);

    $this->readFrequencyExamples($smarty);
  }

  public function getTemplate() {
    return 'authorities/authorities.tpl';
  }

  private function loadByRecords(Smarty &$smarty) {
    $records = Authorities::readByRecords($this->getFilePath('authorities-by-records.csv'), $this->count);

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
          if ($record->{'records-with-authorities'} === 'true') {
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
    // global $solrFields;

    $solrFields = $this->solr()->getSolrFields(); // $this->id
    SchemaUtil::initializeSchema($this->catalogue->getSchemaType());
    if ($this->catalogue->getSchemaType() == 'MARC21') {
      $fields = [
        '100' => 'Main Entry - Personal Name',
        '110' => 'Main Entry - Corporate Name',
        '111' => 'Main Entry - Meeting Name',
        '130' => 'Main Entry - Uniform Title',
        '700' => 'Added Entry - Personal Name',
        '710' => 'Added Entry - Corporate Name',
        '711' => 'Added Entry - Meeting Name',
        '720' => 'Added Entry - Uncontrolled Name',
        '730' => 'Added Entry - Uniform Title',
        '740' => 'Added Entry - Uncontrolled Related/Analytical Title',
        '751' => 'Added Entry - Geographic Name',
        '752' => 'Added Entry - Hierarchical Place Name',
        '753' => 'System Details Access to Computer Files',
        '754' => 'Added Entry - Taxonomic Identification',
        '800' => 'Series Added Entry - Personal Name',
        '810' => 'Series Added Entry - Corporate Name',
        '811' => 'Series Added Entry - Meeting Name',
        '830' => 'Series Added Entry - Uniform Title'
      ];
    } elseif ($this->catalogue->getSchemaType() == 'PICA') {
      $fields = [
        '022A' => 'Werktitel und sonstige unterscheidende Merkmale des Werks',
        '022A/01' => 'Weiterer Werktitel und sonstige unterscheidende Merkmale',
        '028A' => 'Person/Familie als 1. geistiger Schöpfer',
        '028B/01' => '2. und weitere Verfasser',
        '028B/02' => '2. und weitere Verfasser',
        '028C' => 'Person/Familie als 2. und weiterer geistiger Schöpfer, sonstige Personen/Familien, die mit dem Werk in Verbindung stehen, Mitwirkende, Hersteller, Verlage, Vertriebe',
        '028E' => 'Interpret',
        '028G' => 'Sonstige Person/Familie',
        '029A' => 'Körperschaft als 1. geistiger Schöpfer',
        '029E' => 'Körperschaft als Interpret',
        '029F' => 'Körperschaft als 2. und weiterer geistiger Schöpfer, sonstige Körperschaften, die mit dem Werk in Verbindung stehen, Mitwirkende, Hersteller, Verlage, Vertriebe',
        '029G' => 'Sonstige Körperschaft',
        '032V' => 'Sonstige unterscheidende Eigenschaften des Werks',
        '032W' => 'Form des Werks',
        '032X' => 'Besetzung',
        '033D' => 'Normierter Ort',
        '033H' => 'Verbreitungsort in normierter Form',
        '033J' => 'Drucker, Verleger oder Buchhändler (bei Alten Drucken)',
        '037Q' => 'Beschreibung des Einbands',
        '037R' => 'Buchschmuck (Druckermarken, Vignetten, Zierleisten etc.)',
      ];
    } elseif ($this->catalogue->getSchemaType() == 'UNIMARC') {
      $fields = [
        '500' => 'PREFFERRED ACCESS POINT',
        '501' => 'CONVENTIONAL PREFERRED TITLE',
        '506' => 'PREFERRED ACCESS POINT – IDENTIFICATION OF A WORK',
        '507' => 'PREFERRED ACCESS POINT – IDENTIFICATION OF AN EXPRESSION',
        '576' => 'NAME / ACCESS POINT– IDENTIFICATION OF A WORK',
        '577' => 'NAME / ACCESS POINT– IDENTIFICATION OF AN EXPRESSION',
        '620' => 'PLACE AND DATE OF PUBLICATION, PERFORMANCE, ETC.',
        '700' => 'PERSONAL NAME – PRIMARY RESPONSIBILITY',
        '701' => 'PERSONAL NAME – ALTERNATIVE RESPONSIBILITY',
        '702' => 'PERSONAL NAME – SECONDARY RESPONSIBILITY',
        '710$ind1=0' => 'CORPORATE BODY NAME – PRIMARY RESPONSIBILITY',
        '711$ind1=0' => 'CORPORATE BODY NAME – ALTERNATIVE RESPONSIBILITY',
        '712$ind1=0' => 'CORPORATE BODY NAME – SECONDARY RESPONSIBILITY',
        '710$ind1=1' => 'MEETING BODY NAME – PRIMARY RESPONSIBILITY',
        '711$ind1=1' => 'MEETING BODY NAME – ALTERNATIVE RESPONSIBILITY',
        '712$ind1=1' => 'MEETING BODY NAME – SECONDARY RESPONSIBILITY',
        '730' => 'NAME – ENTITY RESPONSIBLE',
        ];
    }
    // Is this even needed?
    $smarty->assign('fields', $fields);
    $smarty->assign('fieldHierarchy', $this->getFieldHierarchy());

    $byRecordsFile = $this->getFilePath('authorities-by-schema.csv');
    if (!file_exists($byRecordsFile)) {
      $byRecordsFile = $this->getFilePath('authorities-by-field.csv');
    }

    if (!file_exists($byRecordsFile)) {
      error_log("By-records file ($byRecordsFile) doesn't exist!");
      return;
    }
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
      $classificationRecord->q = '*:*';

      if ($this->catalogue->getSchemaType() == 'MARC21') {
        $this->setMarc21FacetsAndQueries($classificationRecord);
      } elseif ($this->catalogue->getSchemaType() == 'PICA') {
        $this->setPicaFacets($classificationRecord);
      } elseif ($this->catalogue->getSchemaType() == 'UNIMARC') {
        $this->setUnimarcFacets($classificationRecord);
      } else {
        error_log('unhandled field in classification: ' . $classificationRecord->field);
      }
      if (isset($classificationRecord->facet2) && $classificationRecord->facet2 != '') {
        $classificationRecord->facet2exists = in_array($classificationRecord->facet2, $solrFields);
      }
      if (preg_match('/(^ |  +| $)/', $classificationRecord->scheme)) {
        $classificationRecord->scheme = '"' . str_replace(' ', '&nbsp;', $classificationRecord->scheme) . '"';
      }
      $classificationRecord->ratio = $classificationRecord->recordcount / $this->count;
      $classificationRecord->percent = $classificationRecord->ratio * 100;

      if ($classificationRecord->scheme == 'undetectable') {
        $classificationRecord->scheme = 'source not specified';
      }
      $key = $classificationRecord->field;
      if (!isset($classificationRecords[$key])) {
        $classificationRecords[$key] = [];
      }
      $classificationRecords[$key][] = $classificationRecord;


    }
    $smarty->assign('recordsByField', $classificationRecords);

    $this->readAuthoritiesSubfields($smarty);
    $this->readElements($smarty);
  }

  private function setUnimarcFacets($classificationRecord) {

    $originalField = $classificationRecord->field;
    // If the field starts with 710, 711, or 712, then take into consideration the $ind1 indicator
    if (preg_match('/^71[012]/', $classificationRecord->field)) {
      // Ind1 is the last character of the field
      $ind1 = substr($classificationRecord->field, -1);

      // Take only first three characters of the field
      $classificationRecord->field = substr($classificationRecord->field, 0, 3);

      $this->createFacets($classificationRecord, $classificationRecord->field . 'a');

      // Append the $ind1 indicator to the query
      // This is slightly questionable, as the indicator could be set on some other instance of the field instead
      // However, this issue should be addressed in the entire codebase
      $indicatorQuery = $classificationRecord->field . 'ind1_' . $classificationRecord->field . '_ind1_ss';

      $nameSpecifier = $ind1 == 0 ? 'Corporate name' : 'Meeting name';
      $classificationRecord->q = sprintf('%s:%%22%s%%22', $indicatorQuery, $nameSpecifier);
      $classificationRecord->field = $originalField;

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
    $classificationRecord->field = $originalField;
  }

  private function setPicaFacets($classificationRecord) {
    $classificationRecord->facet = $this->picaToSolr($classificationRecord->field) . '_full_ss';
    $classificationRecord->facet2 = $classificationRecord->facet;
    $classificationRecord->q = '*:*';
    $definition = SchemaUtil::getDefinition($classificationRecord->field);
    $pica3 = ($definition != null && isset($definition->pica3) ? '=' . $definition->pica3 : '');
    $classificationRecord->withPica3 = $classificationRecord->field . $pica3;
  }

  private function setMarc21FacetsAndQueries($classificationRecord) {
    if ($classificationRecord->field == '100') {
      $this->createFacets($classificationRecord, '100a_MainPersonalName_personalName');
      $this->subfield0or2($classificationRecord, 'MainPersonalName');
    } else if ($classificationRecord->field == '110') {
      $this->createFacets($classificationRecord, '110a_MainCorporateName');
      $this->subfield0or2($classificationRecord, 'MainCorporateName');
    } else if ($classificationRecord->field == '111') {
      $this->createFacets($classificationRecord, '111a_MainMeetingName');
      $this->subfield0or2($classificationRecord, 'MainMeetingName');
    } else if ($classificationRecord->field == '130') {
      $this->createFacets($classificationRecord, '130a_MainUniformTitle');
      $this->subfield0or2($classificationRecord, 'MainUniformTitle');
    } else if ($classificationRecord->field == '700') {
      $this->createFacets($classificationRecord, '700a_AddedPersonalName_personalName');
      $this->subfield0or2($classificationRecord, 'AddedPersonalName');
    } else if ($classificationRecord->field == '710') {
      $this->createFacets($classificationRecord, '710a_AddedCorporateName');
      $this->subfield0or2($classificationRecord, 'AddedCorporateName');
    } else if ($classificationRecord->field == '711') {
      $this->createFacets($classificationRecord, '711a_AddedMeetingName');
      $this->subfield0or2($classificationRecord, 'AddedMeetingName');
    } else if ($classificationRecord->field == '720') {
      $this->createFacets($classificationRecord, '720a_UncontrolledName');
      // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
    } else if ($classificationRecord->field == '730') {
      $this->createFacets($classificationRecord, '730a_AddedUniformTitle');
      $this->subfield0or2($classificationRecord, 'AddedUniformTitle');
    } else if ($classificationRecord->field == '740') {
      $this->createFacets($classificationRecord, '740a_AddedUncontrolledRelatedOrAnalyticalTitle');
      // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
    } else if ($classificationRecord->field == '751') {
      $this->createFacets($classificationRecord, '751a_AddedGeographicName');
      // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
    } else if ($classificationRecord->field == '752') {
      $this->createFacets($classificationRecord, '752a_HierarchicalGeographic_country');
      $this->subfield0or2($classificationRecord, 'HierarchicalGeographic');
    } else if ($classificationRecord->field == '753') {
      $this->createFacets($classificationRecord, '753a_SystemRequirement_machineModel');
      // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
    } else if ($classificationRecord->field == '754') {
      $this->createFacets($classificationRecord, '754a_TaxonomicIdentification_name');
      $this->subfield0or2($classificationRecord, 'TaxonomicIdentification');
    } else if ($classificationRecord->field == '800') {
      $this->createFacets($classificationRecord, '800a_SeriesAddedPersonalName_personalName');
      $this->subfield0or2($classificationRecord, 'SeriesAddedPersonalName');
    } else if ($classificationRecord->field == '810') {
      $this->createFacets($classificationRecord, '810a_SeriesAddedCorporateName');
      $this->subfield0or2($classificationRecord, 'SeriesAddedCorporateName');
    } else if ($classificationRecord->field == '811') {
      $this->createFacets($classificationRecord, '811a_SeriesAddedMeetingName');
      $this->subfield0or2($classificationRecord, 'SeriesAddedMeetingName');
    } else if ($classificationRecord->field == '830') {
      $this->createFacets($classificationRecord, '830a_SeriesAddedUniformTitle');
      $this->subfield0or2($classificationRecord, 'SeriesAddedUniformTitle');
    }
  }

  private function readAuthoritiesSubfields(Smarty &$smarty): void {
    $bySubfieldsFile = $this->getFilePath('authorities-by-schema-subfields.csv');
    $this->readSubfields($smarty, $bySubfieldsFile);
  }

  private function getFieldHierarchy() {
    $categoryStatistics = readCsv($this->getFilePath('authorities-by-categories.csv'), 'category');

    if ($this->catalogue->getSchemaType() == 'MARC21') {
      $categories = [
        'Personal names' => (object)[
          'icon' => 'fa-user',
          'fields' => [
            '100' => 'Main Entry - Personal Name',
            '700' => 'Added Entry - Personal Name',
            '800' => 'Series Added Entry - Personal Name',
          ]
        ],
        'Corporate names' => (object)[
          'icon' => 'fa-building',
          'fields' => [
            '110' => 'Main Entry - Corporate Name',
            '710' => 'Added Entry - Corporate Name',
            '810' => 'Series Added Entry - Corporate Name',
          ]
        ],
        'Meeting names' => (object)[
          'icon' => 'fa-calendar',
          'fields' => [
            '111' => 'Main Entry - Meeting Name',
            '711' => 'Added Entry - Meeting Name',
            '811' => 'Series Added Entry - Meeting Name',
          ]
        ],
        'Geographic names' => (object)[
          'icon' => 'fa-map',
          'fields' => [
            '751' => 'Added Entry - Geographic Name',
            '752' => 'Added Entry - Hierarchical Place Name',
          ]
        ],
        'Titles' => (object)[
          'icon' => 'fa-book',
          'fields' => [
            '130' => 'Main Entry - Uniform Title',
            '730' => 'Added Entry - Uniform Title',
            '740' => 'Added Entry - Uncontrolled Related/Analytical Title',
            '830' => 'Series Added Entry - Uniform Title'
          ]
        ],
        'Other' => (object)[
          'icon' => 'fa-archive',
          'fields' => [
            '720' => 'Added Entry - Uncontrolled Name',
            '753' => 'System Details Access to Computer Files',
            '754' => 'Added Entry - Taxonomic Identification',
          ]
        ]
      ];
    } else if ($this->catalogue->getSchemaType() == 'PICA') {
      $categories = [
        'Personal names' => (object)[
          'icon' => 'fa-user',
          'fields' => [
            '028A' => 'Person/Familie als 1. geistiger Schöpfer',
            '028B/01' => '2. und weitere Verfasser',
            '028B/02' => '2. und weitere Verfasser',
            '028C' => 'Person/Familie als 2. und weiterer geistiger Schöpfer, sonstige Personen/Familien, die mit dem Werk in Verbindung stehen, Mitwirkende, Hersteller, Verlage, Vertriebe',
            '028E' => 'Interpret',
            '028G' => 'Sonstige Person/Familie',
          ]
        ],
        'Corporate names' => (object)[
          'icon' => 'fa-building',
          'fields' => [
            '029A' => 'Körperschaft als 1. geistiger Schöpfer',
            '033J' => 'Drucker, Verleger oder Buchhändler (bei Alten Drucken)',
            '029E' => 'Körperschaft als Interpret',
            '029F' => 'Körperschaft als 2. und weiterer geistiger Schöpfer, sonstige Körperschaften, die mit dem Werk in Verbindung stehen, Mitwirkende, Hersteller, Verlage, Vertriebe',
            '029G' => 'Sonstige Körperschaft',
          ]
        ],
        'Meeting names' => (object)[
          'icon' => 'fa-calendar',
          'fields' => []
        ],
        'Geographic names' => (object)[
          'icon' => 'fa-map',
          'fields' => [
            '033D' => 'Normierter Ort',
            '033H' => 'Verbreitungsort in normierter Form',
          ]
        ],
        'Titles' => (object)[
          'icon' => 'fa-book',
          'fields' => [
            '022A' => 'Werktitel und sonstige unterscheidende Merkmale des Werks',
            '022A/01' => 'Weiterer Werktitel und sonstige unterscheidende Merkmale',
          ]
        ],
        'Other' => (object)[
          'icon' => 'fa-archive',
          'fields' => [
            '032V' => 'Sonstige unterscheidende Eigenschaften des Werks',
            '032W' => 'Form des Werks',
            '032X' => 'Besetzung',
            '037Q' => 'Beschreibung des Einbands',
            '037R' => 'Buchschmuck (Druckermarken, Vignetten, Zierleisten etc.)',
          ]
        ]
      ];
    } elseif ($this->catalogue->getSchemaType() == 'UNIMARC') {
      $categories = [
        'Personal names' => (object)[
          'icon' => 'fa-user',
          'fields' => [
            '700' => 'PERSONAL NAME – PRIMARY RESPONSIBILITY',
            '701' => 'PERSONAL NAME – ALTERNATIVE RESPONSIBILITY',
            '702' => 'PERSONAL NAME – SECONDARY RESPONSIBILITY',
          ]
        ],
        'Corporate names' => (object)[
          'icon' => 'fa-building',
          'fields' => [
            '710$ind1=0' => 'CORPORATE BODY NAME – PRIMARY RESPONSIBILITY',
            '711$ind1=0' => 'CORPORATE BODY NAME – ALTERNATIVE RESPONSIBILITY',
            '712$ind1=0' => 'CORPORATE BODY NAME – SECONDARY RESPONSIBILITY',
          ]
        ],
        'Meeting names' => (object)[
          'icon' => 'fa-calendar',
          'fields' => [
            '710$ind1=1' => 'MEETING BODY NAME – PRIMARY RESPONSIBILITY',
            '711$ind1=1' => 'MEETING BODY NAME – ALTERNATIVE RESPONSIBILITY',
            '712$ind1=1' => 'MEETING BODY NAME – SECONDARY RESPONSIBILITY',
          ]
        ],
        'Geographic names' => (object)[
          'icon' => 'fa-map',
          'fields' => [
            '620' => 'PLACE AND DATE OF PUBLICATION, PERFORMANCE, ETC.',
          ]
        ],
        'Titles' => (object)[
          'icon' => 'fa-book',
          'fields' => [
            '501' => 'CONVENTIONAL PREFERRED TITLE',
            '506' => 'PREFERRED ACCESS POINT – IDENTIFICATION OF A WORK',
            '507' => 'PREFERRED ACCESS POINT – IDENTIFICATION OF AN EXPRESSION',
            '576' => 'NAME / ACCESS POINT– IDENTIFICATION OF A WORK',
            '577' => 'NAME / ACCESS POINT– IDENTIFICATION OF AN EXPRESSION',
          ]
        ],
        'Other' => (object)[
          'icon' => 'fa-archive',
          'fields' => [
            '730' => 'NAME – ENTITY RESPONSIBLE',
          ]
        ]
      ];
    }

    foreach ($categories as $name => $obj) {
      $obj->recordcount = isset($categoryStatistics[$name]) ? $categoryStatistics[$name]->recordcount : 0;
      $obj->instancecount = isset($categoryStatistics[$name]) ? $categoryStatistics[$name]->instancecount : 0;
      $obj->ratio = $obj->recordcount / $this->count;
      $obj->percent = $obj->ratio * 100;
      foreach ($obj->fields as $key => $value) {
        $obj->fields[$key] = (object)['name' => $value];
        if ($this->catalogue->getSchemaType() != 'PICA') {
          continue;
        }
        $definition = SchemaUtil::getDefinition($key);
        if ($definition != null && isset($definition->pica3)) {
          $obj->fields[$key]->pica3 = $key . '=' . $definition->pica3;
        }
      }
    }
    return $categories;
  }

  private function readFrequencyExamples(Smarty &$smarty) {
    $file = $this->getFilePath('authorities-frequency-examples.csv');
    if (!file_exists($file)) {
      return;
    }
    $frequencyExamples = readCsv($file);
    $examples = [];
    foreach ($frequencyExamples as $example) {
      $examples[$example->count] = $example->id;
    }
    $smarty->assign('frequencyExamples', $examples);
  }
}
