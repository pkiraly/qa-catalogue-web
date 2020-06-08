<?php
require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");
$countFile = sprintf('%s/%s/tt-completeness.csv', $configuration['dir'], $db);
$solrFields = getSolrFields($db);

$result = new stdClass();
// $result->byRecord = readByRecords($configuration['dir'], $db);
// $result->byField = readByField($configuration['dir'], $db);
$result->histogram = readHistogram($configuration['dir'], $db);

header('Content-Type: application/json');
echo json_encode($result);

function readHistogram($dir, $db) {
  global $smarty, $countFile;

  $byRecordsFile = sprintf('%s/%s/tt-completeness-fields.csv', $dir, $db);
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
        if ($record->name != 'id' && $record->name != 'total')
          $records[] = $record;
      }
    }
    $smarty->assign('fields', $records);
    $smarty->assign('db', $db);
    return $smarty->fetch('tt-completeness-histogram.tpl');
  }
  return null;
}

function readByRecords($dir, $db) {
  global $smarty, $countFile;

  $count = trim(file_get_contents($countFile));
  $byRecordsFile = sprintf('%s/%s/authorities-by-records.csv', $dir, $db);
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

    $smarty->assign('records', $records);
    $smarty->assign('count', $count);
    $smarty->assign('withClassification', $withClassification);
    $smarty->assign('withoutClassification', $withoutClassification);

    return $smarty->fetch('authorities-by-records.tpl');
  }
  return NULL;
}

function readByField($dir, $db) {
  global $smarty, $solrFields;

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

  $solrFieldMap = getSolrFieldMap();

  $byRecordsFile = sprintf('%s/%s/authorities-by-schema.csv', $dir, $db);
  if (!file_exists($byRecordsFile)) {
    $byRecordsFile = sprintf('%s/%s/authorities-by-field.csv', $dir, $db);
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
        if ($record->field == '100') {
          createFacets($record, '100a_MainPersonalName_personalName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '110') {
          createFacets($record, '110a_MainCorporateName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '111') {
          createFacets($record, '111a_MainMeetingName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '130') {
          createFacets($record, '130a_MainUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '700') {
          createFacets($record, '700a_AddedPersonalName_personalName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '710') {
          createFacets($record, '710a_AddedCorporateName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '711') {
          createFacets($record, '711a_AddedMeetingName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '720') {
          createFacets($record, '130a_MainUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '730') {
          createFacets($record, '730a_AddedUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '740') {
          createFacets($record, '740a_AddedUncontrolledRelatedOrAnalyticalTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '751') {
          createFacets($record, '751a_AddedGeographicName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '752') {
          createFacets($record, '130a_MainUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '753') {
          createFacets($record, '130a_MainUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '754') {
          createFacets($record, '130a_MainUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '800') {
          createFacets($record, '100a_MainPersonalName_personalName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '810') {
          createFacets($record, '110a_MainCorporateName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '811') {
          createFacets($record, '111a_MainMeetingName');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '820') {
          createFacets($record, '130a_MainUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        } else if ($record->field == '830') {
          createFacets($record, '830a_SeriesAddedUniformTitle');
          // ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          $record->q = '*:*';
        }

        if (isset($record->facet2) && $record->facet2 != '') {
          $record->facet2exists = in_array($record->facet2, $solrFields);
        }

        if (preg_match('/(^ |  +| $)/', $record->scheme)) {
          $record->scheme = '"' . str_replace(' ', '&nbsp;', $record->scheme) . '"';
        }

        if ($record->scheme == 'undetectable')
          $record->scheme = 'source not specified';

        $records[] = $record;
      }
    }
    $smarty->assign('records', $records);
    $smarty->assign('fields', $fields);

    readSubfields($dir, $db, $smarty);
    readElements($dir, $db, $smarty);

    return $smarty->fetch('authorities-by-field.tpl');
  }
  return NULL;
}

/**
 * @param $record
 * @param $base
 */
function createFacets(&$record, $base) {
  global $solrFields;

  $record->facet = $base . '_ss';

  if (isset($record->abbreviation4solr)
      && $record->abbreviation4solr != ''
      && in_array($record->abbreviation4solr, $solrFields)) {
    $record->facet2 = $base . '_' . $record->abbreviation4solr . '_ss';
  } elseif (isset($record->abbreviation)
            && $record->abbreviation != ''
            && in_array($record->abbreviation, $solrFields)) {
    $record->facet2 = $base . '_' . $record->abbreviation . '_ss';
  }
}

/**
 * @param $dir
 * @param $db
 * @param Smarty $smarty
 * @return object
 */
function readSubfields($dir, $db, Smarty &$smarty) {
  $bySubfieldsFile = sprintf('%s/%s/authorities-by-schema-subfields.csv', $dir, $db);
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
    $smarty->assign('subfields', $subfields);
    $smarty->assign('hasSubfields', TRUE);

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

    $smarty->assign('subfieldsById', $subfieldsById);
  } else {
    $smarty->assign('hasSubfields', FALSE);
  }
}

/**
 * @param $dir
 * @param $db
 * @param Smarty $smarty
 * @return object
 */
function readElements($dir, $db, Smarty &$smarty) {
  $elementsFile = sprintf('%s/%s/marc-elements.csv', $dir, $db);
  if (file_exists($elementsFile)) {
    $header = [];
    $elements = [];
    $in = fopen($elementsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        $record = (object)array_combine($header, $values);
        $elements[$record->path] = $record->subfield;
      }
    }
    $smarty->assign('hasElements', TRUE);
    $smarty->assign('elements', $elements);
  } else {
    $smarty->assign('hasElements', FALSE);
  }
}

function ind1Orsubfield2(&$record, $ind1, $subfield2) {
  $debug = ($record->field == '052');
  if ($debug)
    error_log('location: ' . $record->location);
  if ($record->location == 'ind1') {
    $record->q = sprintf('%s:%%22%s%%22', $ind1, $record->scheme);
  } else if ($record->location == '$2') {
    if ($record->scheme == 'undetectable') {
      $record->q = sprintf('%s:%%22Source specified in subfield \$2%%22 NOT %s:*', $ind1, $subfield2);
    } else {
      $record->q = sprintf('%s:%%22%s%%22', $subfield2, $record->scheme);
    }
  }
  if ($debug)
    error_log('q: ' . $record->q);
}

function ind2Orsubfield2(&$record, $ind2, $subfield2) {
  if ($record->location == 'ind2') {
    $record->q = sprintf('%s:%%22%s%%22', $ind2, $record->scheme);
  } else if ($record->location == '$2') {
    if ($record->scheme == 'undetectable') {
      $record->q = sprintf('%s:%%22Source specified in subfield \$2%%22 NOT %s:*', $ind2, $subfield2);
    } else {
      $record->q = sprintf('%s:%%22%s%%22', $subfield2, $record->scheme);
    }
  }
}

function getSolrFieldMap() {
  global $db;

  $solrFieldMap = [];
  $fields = getSolrFields($db);
  foreach ($fields as $field) {
    $parts = explode('_', $field);
    $solrFieldMap[$parts[0]] = $field;
  }

  return $solrFieldMap;
}

/**
 * @param array $db
 * @return array
 */
function getSolrFields() {
  global $db;

  $url = 'http://localhost:8983/solr/' . $db;
  $all_fields = file_get_contents($url . '/select/?q=*:*&wt=csv&rows=0');
  $fields = explode(',', $all_fields);

  return $fields;
}

