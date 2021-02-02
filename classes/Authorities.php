<?php


class Authorities extends AddedEntry {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->readCount();
    $this->readByRecords($smarty);
    $this->readByField($smarty);

    $this->readFrequencyExamples($smarty);
  }

  public function getTemplate() {
    return 'authorities.tpl';
  }

  private function readByRecords(Smarty &$smarty) {

    $byRecordsFile = $this->getFilePath('authorities-by-records.csv');
    $records = [];
    if (file_exists($byRecordsFile)) {
      $header = [];
      $withClassification = NULL;
      $withoutClassification = NULL;
      $in = fopen($byRecordsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $record->percent = $record->count / $this->count;
          $records[] = $record;
          if ($record->{'records-with-authorities'} === 'true') {
            $withClassification = $record;
          } else {
            $withoutClassification = $record;
          }
        }
      }

      $smarty->assign('records', $records);
      $smarty->assign('count', $this->count);
      $smarty->assign('withClassification', $withClassification);
      $smarty->assign('withoutClassification', $withoutClassification);
    }
  }

  private function readByField(Smarty &$smarty) {
    global $solrFields;

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
    $smarty->assign('fields', $fields);
    $smarty->assign('fieldHierarchy', $this->getFieldHierarchy());


    $byRecordsFile = $this->getFilePath('authorities-by-schema.csv');
    if (!file_exists($byRecordsFile)) {
      $byRecordsFile = $this->getFilePath('authorities-by-field.csv');
    }

    if (file_exists($byRecordsFile)) {
      $header = [];
      $records = [];
      $in = fopen($byRecordsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          if (!isset($record->field))
            error_log('empty? ' . $line);

          $record->q = '*:*';
          if ($record->field == '100') {
            $this->createFacets($record, '100a_MainPersonalName_personalName');
            $this->subfield0or2($record, 'MainPersonalName');
          } else if ($record->field == '110') {
            $this->createFacets($record, '110a_MainCorporateName');
            $this->subfield0or2($record, 'MainCorporateName');
          } else if ($record->field == '111') {
            $this->createFacets($record, '111a_MainMeetingName');
            $this->subfield0or2($record, 'MainMeetingName');
          } else if ($record->field == '130') {
            $this->createFacets($record, '130a_MainUniformTitle');
            $this->subfield0or2($record, 'MainUniformTitle');
          } else if ($record->field == '700') {
            $this->createFacets($record, '700a_AddedPersonalName_personalName');
            $this->subfield0or2($record, 'AddedPersonalName');
          } else if ($record->field == '710') {
            $this->createFacets($record, '710a_AddedCorporateName');
            $this->subfield0or2($record, 'AddedCorporateName');
          } else if ($record->field == '711') {
            $this->createFacets($record, '711a_AddedMeetingName');
            $this->subfield0or2($record, 'AddedMeetingName');
          } else if ($record->field == '720') {
            $this->createFacets($record, '720a_UncontrolledName');
            // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
          } else if ($record->field == '730') {
            $this->createFacets($record, '730a_AddedUniformTitle');
            $this->subfield0or2($record, 'AddedUniformTitle');
          } else if ($record->field == '740') {
            $this->createFacets($record, '740a_AddedUncontrolledRelatedOrAnalyticalTitle');
            // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
          } else if ($record->field == '751') {
            $this->createFacets($record, '751a_AddedGeographicName');
            // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
          } else if ($record->field == '752') {
            $this->createFacets($record, '752a_HierarchicalGeographic_country');
            $this->subfield0or2($record, 'HierarchicalGeographic');
          } else if ($record->field == '753') {
            $this->createFacets($record, '753a_SystemRequirement_machineModel');
            // $this->subfield0or2($record, '1000_MainPersonalName_authorityRecordControlNumber_organizationCode_ss', '1002_MainPersonalName_source_ss');
          } else if ($record->field == '754') {
            $this->createFacets($record, '754a_TaxonomicIdentification_name');
            $this->subfield0or2($record, 'TaxonomicIdentification');
          } else if ($record->field == '800') {
            $this->createFacets($record, '800a_SeriesAddedPersonalName_personalName');
            $this->subfield0or2($record, 'SeriesAddedPersonalName');
          } else if ($record->field == '810') {
            $this->createFacets($record, '810a_SeriesAddedCorporateName');
            $this->subfield0or2($record, 'SeriesAddedCorporateName');
          } else if ($record->field == '811') {
            $this->createFacets($record, '811a_SeriesAddedMeetingName');
            $this->subfield0or2($record, 'SeriesAddedMeetingName');
          } else if ($record->field == '830') {
            $this->createFacets($record, '830a_SeriesAddedUniformTitle');
            $this->subfield0or2($record, 'SeriesAddedUniformTitle');
          }

          if (isset($record->facet2) && $record->facet2 != '') {
            $record->facet2exists = in_array($record->facet2, $solrFields);
          }

          if (preg_match('/(^ |  +| $)/', $record->scheme)) {
            $record->scheme = '"' . str_replace(' ', '&nbsp;', $record->scheme) . '"';
          }

          $record->ratio = $record->recordcount / $this->count;
          $record->percent = $record->ratio * 100;

          if ($record->scheme == 'undetectable')
            $record->scheme = 'source not specified';

          if (!isset($records[$record->field]))
            $records[$record->field] = [];
          $records[$record->field][] = $record;
        }
      }
      $smarty->assign('recordsByField', $records);

      $this->readAuthoritiesSubfields($smarty);
      $this->readElements($smarty);
    }
  }

  /**
   * @param $dir
   * @param $db
   * @param Smarty $smarty
   * @return object
   */
  private function readAuthoritiesSubfields(Smarty &$smarty) {
    $bySubfieldsFile = $this->getFilePath('authorities-by-schema-subfields.csv');
    $this->readSubfields($smarty, $bySubfieldsFile);
  }

  private function getFieldHierarchy() {
    $categoryStatistics = readCsv($this->getFilePath('authorities-by-categories.csv'), 'category');
    error_log(json_encode($categoryStatistics));

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
    foreach ($categories as $name => $obj) {
      $obj->recordcount = $categoryStatistics[$name]->recordcount;
      $obj->instancecount = $categoryStatistics[$name]->instancecount;
      $obj->ratio = $obj->recordcount / $this->count;
      $obj->percent = $obj->ratio * 100;
    }
    return $categories;
  }

  private function readFrequencyExamples(Smarty &$smarty) {
    $file = $this->getFilePath('authorities-frequency-examples.csv');
    if (file_exists($file)) {
      $frequencyExamples = readCsv($file);
      $examples = [];
      foreach ($frequencyExamples as $example) {
        $examples[$example->count] = $example->id;
      }
      $smarty->assign('frequencyExamples', $examples);
    }
  }
}