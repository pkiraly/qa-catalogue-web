<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class AuthoritiesController extends BaseContextualController
{
  private $solrFields;

  /**
   * @Route("/authorities")
   */
  public function run() {
    $number = 3;
    $this->selectTab('authorities');
    return $this->render('authorities/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
      'prefix' => 'authority',
      'byRecord' => $this->readByRecords(),  // authorities-by-records.tpl
      'byField' => $this->readByField(),     // authorities-by-field.tpl
      'has_histogram' => $this->readHistogram(), // authorities-histogram.tpl
    ]);
  }

  private function readHistogram() {
    $byRecordsFile = $this->getDir() . '/authorities-histogram.csv';
    if (file_exists($byRecordsFile)) {
      return true;
    }
    return false;
  }

  private function readByRecords() {
    $count = trim(file_get_contents($this->getDir() . '/count.csv'));
    $byRecordsFile = $this->getDir() . '/authorities-by-records.csv';
    if (file_exists($byRecordsFile)) {
      $header = [];
      $records = [];
      $withClassification = NULL;
      $withoutClassification = NULL;
      $in = fopen($byRecordsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $record->percent = $record->count / $count;
          $records[] = $record;
          if ($record->{'records-with-authorities'} === 'true') {
            $withClassification = $record;
          } else {
            $withoutClassification = $record;
          }
        }
      }

      return [
        'records' => $records,
        'count' => $count,
        'withClassification' => $withClassification,
        'withoutClassification' => $withoutClassification
      ];
    }
    return NULL;
  }

  private function readByField() {
    $this->solrFields = $this->getSolrFields();

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

    $this->solrFieldMap = $this->getSolrFieldMap();

    $byRecordsFile = $this->getDir() . '/authorities-by-schema.csv';
    if (!file_exists($byRecordsFile)) {
      $byRecordsFile = $this->getDir() . '/authorities-by-field.csv';
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
          } else if ($record->field == '110') {
            $this->createFacets($record, '110a_MainCorporateName');
          } else if ($record->field == '111') {
            $this->createFacets($record, '111a_MainMeetingName');
          } else if ($record->field == '130') {
            $this->createFacets($record, '130a_MainUniformTitle');
          } else if ($record->field == '700') {
            $this->createFacets($record, '700a_AddedPersonalName_personalName');
          } else if ($record->field == '710') {
            $this->createFacets($record, '710a_AddedCorporateName');
          } else if ($record->field == '711') {
            $this->createFacets($record, '711a_AddedMeetingName');
          } else if ($record->field == '720') {
            $this->createFacets($record, '130a_MainUniformTitle');
          } else if ($record->field == '730') {
            $this->createFacets($record, '730a_AddedUniformTitle');
          } else if ($record->field == '740') {
            $this->createFacets($record, '740a_AddedUncontrolledRelatedOrAnalyticalTitle');
          } else if ($record->field == '751') {
            $this->createFacets($record, '751a_AddedGeographicName');
          } else if ($record->field == '752') {
            $this->createFacets($record, '130a_MainUniformTitle');
          } else if ($record->field == '753') {
            $this->createFacets($record, '130a_MainUniformTitle');
          } else if ($record->field == '754') {
            $this->createFacets($record, '130a_MainUniformTitle');
          } else if ($record->field == '800') {
            $this->createFacets($record, '100a_MainPersonalName_personalName');
          } else if ($record->field == '810') {
            $this->createFacets($record, '110a_MainCorporateName');
          } else if ($record->field == '811') {
            $this->createFacets($record, '111a_MainMeetingName');
          } else if ($record->field == '820') {
            $this->createFacets($record, '130a_MainUniformTitle');
          } else if ($record->field == '830') {
            $this->createFacets($record, '830a_SeriesAddedUniformTitle');
          }

          if (isset($record->facet2) && $record->facet2 != '') {
            $record->facet2exists = in_array($record->facet2, $this->solrFields);
          }

          if (preg_match('/(^ |  +| $)/', $record->scheme)) {
            $record->scheme = '"' . str_replace(' ', '&nbsp;', $record->scheme) . '"';
          }

          if ($record->scheme == 'undetectable')
             $record->scheme = 'source not specified';

          $records[] = $record;
        }
      }
      // id,field,location,scheme,abbreviation,abbreviation4solr,recordcount,instancecount

      $data = [
        'records' => $records,
        'fields' => $fields
      ];
      $data += $this->readSubfields();
      $data += $this->readElements();
      return $data;
    }
    return NULL;
  }

  private function getSolrFieldMap() {
    if (is_null($this->solrFields))
      $this->solrFields = $this->getSolrFields();

    $solrFieldMap = [];
    foreach ($this->solrFields as $field) {
      $parts = explode('_', $field);
      $solrFieldMap[$parts[0]] = $field;
    }

    return $solrFieldMap;
  }

  /**
   * @param $record
   * @param $base
   */
  private function createFacets(&$record, $base) {
    $record->facet = $base . '_ss';

    if (isset($record->abbreviation4solr)
        && $record->abbreviation4solr != ''
        && in_array($record->abbreviation4solr, $this->solrFields)) {
      $record->facet2 = $base . '_' . $record->abbreviation4solr . '_ss';
    } elseif (isset($record->abbreviation)
        && $record->abbreviation != ''
        && in_array($record->abbreviation, $this->solrFields)) {
      $record->facet2 = $base . '_' . $record->abbreviation . '_ss';
    }
  }

  private function readSubfields() {
    $data = [];
    $bySubfieldsFile = $this->getDir() . '/authorities-by-schema-subfields.csv';
    if (file_exists($bySubfieldsFile)) {
      $header = [];
      $subfields = [];
      $subfieldsById = [];
      $in = fopen($bySubfieldsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $record->subfields = explode(';', $record->subfields);
          $items = [];
          $hasPlus = FALSE;
          $hasSpace = FALSE;
          foreach ($record->subfields as $subfield) {
            if ($subfield == ' ') {
              $subfield = '_';
              $hasSpace = TRUE;
            }
            $subfield = '$' . $subfield;
            $items[] = $subfield;
            if (preg_match('/\+$/', $subfield)) {
              $hasPlus = TRUE;
              $subfield = str_replace('+', '', $subfield);
            }
            if (!isset($subfieldsById[$record->id]))
              $subfieldsById[$record->id] = [];
            if (!in_array($subfield, $subfieldsById[$record->id]))
              $subfieldsById[$record->id][] = $subfield;
          }
          $record->subfields = $items;
          if (!isset($subfields[$record->id])) {
            $subfields[$record->id] = ['list' => [], 'has-plus' => FALSE, 'has-space' => FALSE];
          }
          $subfields[$record->id]['list'][] = $record;
          if ($hasPlus)
            $subfields[$record->id]['has-plus'] = TRUE;
          if ($hasSpace)
            $subfields[$record->id]['has-space'] = TRUE;

        }
      }
      $data['subfields'] = $subfields;
      $data['hasSubfields'] = TRUE;

      foreach ($subfieldsById as $id => $subfields) {
        sort($subfields);
        $nums = [];
        $alpha = [];
        foreach ($subfields as $subfield) {
          if (preg_match('/\d$/', $subfield)) {
            $nums[] = $subfield;
          } else {
            $alpha[] = $subfield;
          }
        }
        $subfields = array_merge($alpha, $nums);
        $subfieldsById[$id] = $subfields;
      }

      $data['subfieldsById'] = $subfieldsById;
    } else {
      $data['hasSubfields'] = FALSE;
    }

    return $data;
  }


}