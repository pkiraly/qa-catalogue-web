<?php

include_once 'common-functions.php';
$smarty = createSmarty('templates');

$facetLabels = [
  '041a_Language_ss' => 'language',
  '040b_AdminMetadata_languageOfCataloging_ss' => 'language of cataloging',
  'Leader_06_typeOfRecord_ss' => 'record type',
  'Leader_18_descriptiveCatalogingForm_ss' => 'cataloging form',
  '650a_Topic_topicalTerm_ss' => 'topic',
  '650z_Topic_geographicSubdivision_ss' => 'geographic',
  '650v_Topic_formSubdivision_ss' => 'form',
  '6500_Topic_authorityRecordControlNumber_ss' => 'topic id',
  '6510_Geographic_authorityRecordControlNumber_ss' => 'geo id',
  '6550_GenreForm_authorityRecordControlNumber_ss' => 'genre id',
  '9129_WorkIdentifier_ss' => 'work id',
  '9119_ManifestationIdentifier_ss' => 'manifestation id'
];

$core = $_GET['core'];
$solrResponse = getSolrResponse();

if (!is_null($solrResponse)) {
  $result = (object)[
    'numFound' => $solrResponse->response->numFound,
    'records' => getRecords($solrResponse),
    'facets' => getFacets($solrResponse),
  ];

  header('Content-Type: application/json');
  echo json_encode($result);
}

function getRecords($solrResponse) {
  global $smarty;

  $smarty->assign('docs', $solrResponse->response->docs);
  $smarty->registerPlugin("function", "hasPublication", "hasPublication");
  $smarty->registerPlugin("function", "hasPhysicalDescription", "hasPhysicalDescription");
  $smarty->registerPlugin("function", "hasMainPersonalName", "hasMainPersonalName");
  $smarty->registerPlugin("function", "hasSimilarBooks", "hasSimilarBooks");
  $smarty->registerPlugin("function", "getAllSolrFields", "getAllSolrFields");
  $smarty->registerPlugin("function", "getMarcFields", "getMarcFields");
  $smarty->registerPlugin("function", "opacLink", "opacLink");
  $smarty->registerPlugin("function", "getRecord", "getRecord");
  $smarty->registerPlugin("function", "getField", "getField");
  $smarty->registerPlugin("function", "getFields", "getFields");
  $smarty->registerPlugin("function", "getSubfields", "getSubfields");
  $smarty->registerPlugin("function", "hasAuthorityNames", "hasAuthorityNames");
  $smarty->registerPlugin("function", "hasSubjectHeadings", "hasSubjectHeadings");

  return $smarty->fetch('marc-records-based-on-marcjson.tpl');
}

function getFacets($solrResponse) {
  global $smarty;

  $smarty->assign('facets', $solrResponse->facet_counts->facet_fields);
  $smarty->assign('params', $solrResponse->responseHeader->params);
  $smarty->registerPlugin("function", "getFacetLabel", "getFacetLabel");
  return $smarty->fetch('marc-facets.tpl');
}

function getFacetLabel($facet) {
  global $facetLabels;
  if (isset($facetLabels[$facet]))
    return $facetLabels[$facet];
  return str_replace('_', ' ', preg_replace('/_ss$/', '', $facet));
}

function getMarcFields($doc) {
  if (is_string($doc->record_sni)) {
    $marc = json_decode($doc->record_sni);
  } else {
    $marc = json_decode($doc->record_sni[0]);
  }

  $rows = [];
  foreach ($marc as $tag => $value) {
    if (preg_match('/^00/', $tag)) {
      $rows[] = [$tag, '', '', '', $value];
    } else if ($tag == 'leader') {
      $rows[] = ['LDR', '', '', '', $value];
    } else {
      foreach ($value as $instance) {
        $firstRow = [$tag, $instance->ind1, $instance->ind2];
        $i = 0;
        foreach ($instance->subfields as $code => $s_value) {
          $i++;
          if ($i == 1) {
            $firstRow[] = '$' . $code;
            $firstRow[] = $s_value;
            $rows[] = $firstRow;
          } else {
            $rows[] = ['', '', '', '$' . $code, $s_value];
          }
        }
      }
    }
  }
  return $rows;
}

function getAllSolrFields($doc) {
  $fields = [];
  foreach ($doc as $label => $value) {
    if ($label == 'record_sni' || $label == '_version_') {
      continue;
    }

    $fields[] = (object)['label' => $label, 'value' => $value];
  }
  return $fields;
}

function hasPublication($doc) {
  return (!empty($doc->{'260a_Publication_place_ss'})
    || !empty($doc->{'260b_Publication_agent_ss'})
    || !empty($doc->{'260c_Publication_date_ss'}));
}

function getRecord($doc) {
  return json_decode($doc->record_sni);
}

function getField($record, $fieldName) {
  if (isset($record->{$fieldName}))
    return $record->{$fieldName}[0];
  return null;
}

function getFields($record, $fieldName) {
  if (isset($record->{$fieldName}))
    return $record->{$fieldName};
  return null;
}

function getSubfields($record, $fieldName, $subfield) {
  $subfields = [];
  if (isset($record->{$fieldName})) {
    foreach($record->{$fieldName} as $field) {
      if (isset($field->subfields->{$subfield})) {
        $subfields[] = $field->subfields->{$subfield};
      }
    }
  }
  return $subfields;
}

function hasAuthorityNames($record) {
  $fields = [
    '100', '110', '111', '130',
    '700', '710', '711', '720', '730', '740', '751', '752', '753', '754',
    '800', '810', '811', '830',
  ];
  $hasAuthorityNames = false;
  foreach ($fields as $fieldName) {
    if (isset($record->{$fieldName})) {
      $hasAuthorityNames = true;
      break;
    }
  }
  return $hasAuthorityNames;
}

function hasSubjectHeadings($record) {
  $fields = ['080', '600', '610', '611', '630', '647', '648', '650', '651', '653', '655'];
  $hasSubjectHeadings = false;
  foreach ($fields as $fieldName) {
    if (isset($record->{$fieldName})) {
      $hasSubjectHeadings = true;
      break;
    }
  }
  return $hasSubjectHeadings;
}

function hasPhysicalDescription($doc) {
  return (!empty($doc->{'300a_PhysicalDescription_extent_ss'})
    || !empty($doc->{'300c_PhysicalDescription_dimensions_ss'}));
}

function hasMainPersonalName($doc) {
  return (!empty($doc->{'100a_MainPersonalName_personalName_ss'})
          || !empty($doc->{'100d_MainPersonalName_dates_ss'}));
}

function hasSimilarBooks($doc) {
  return (!empty($doc->{'9129_WorkIdentifier_ss'})
          || !empty($doc->{'9119_ManifestationIdentifier_ss'}));
}

function opacLink($doc, $id) {
  global $core;
  if ($core == 'szte')
    return 'http://qulto.bibl.u-szeged.hu/record/-/record/' . trim($id);
  else if ($core == 'mokka')
    return 'http://mokka.hu/web/guest/record/-/record/' . trim($id);
  else if ($core == 'cerl') {
    $identifier = '';
    foreach ($doc->{'035a_SystemControlNumber_ss'} as $tag35a) {
      if (!preg_match('/OCoLC/', $tag35a)) {
        $identifier = $tag35a;
        break;
      }
    }
    return 'http://hpb.cerl.org/record/' . $identifier;
  } else if ($core == 'dnb')
    return 'http://d-nb.info/' . trim($id);
  else if ($core == 'gent')
    return 'https://lib.ugent.be/catalog/rug01:' . trim($id);
  else if ($core == 'loc')
    return 'https://lccn.loc.gov/' . trim($id);
  else if ($core == 'mtak')
    return 'https://mta-primotc.hosted.exlibrisgroup.com/permalink/f/1s1uct8/36MTA' . trim($id);
  else if ($core == 'bayern')
    return 'http://gateway-bayern.de/' . trim($id);
  else if ($core == 'bnpl') {
    foreach ($doc->{'035a_SystemControlNumber_ss'} as $tag35a) {
      if (preg_match('/^\d/', $tag35a)) {
        $identifier = $tag35a;
        break;
      }
    }
    return sprintf(
        'https://katalogi.bn.org.pl/discovery/fulldisplay?docid=alma%s&context=L&vid=48OMNIS_NLOP:48OMNIS_NLOP&search_scope=NLOP_IZ_NZ&tab=LibraryCatalog&lang=pl',
        trim($identifier));

  } else if ($core == 'nfi') {
    // return 'https://melinda.kansalliskirjasto.fi/byid/' . trim($id);
    return 'https://kansalliskirjasto.finna.fi/Search/Results?bool0[]=OR&lookfor0[]=ctrlnum%3A%22FCC'
      . trim($id)
      . '%22&lookfor0[]=ctrlnum%3A%22(FI-MELINDA)'
      . trim($id)
      . '%22';
  }
}

/**
 * Executes the Solr query and returns the JSON response.
 */
function getSolrResponse() {
  static $cores = ['cerl', 'cerl2', 'stanford', 'dnb', 'gent', 'szte', 'mokka', 'loc', 'mtak', 'bayern', 'bnpl', 'nfi'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $query = $_SERVER['QUERY_STRING'];

    $params = [];
    $parts = explode('&', $query);
    foreach ($parts as $part) {
      if ($part == '')
        continue;

      list($k, $v) = explode('=', $part);
      if ($k == 'core' || $k == '_'  || $k == 'json.wrf' || $v == '') { //
        continue;
      }
      if ($k == 'q') {
        error_log($v);
      }
      if (!preg_match('/%/', $v))
        $v = urlencode($v);
      $params[] = $k . '=' . $v;
    }
    $params[] = 'indent=false';

    $core = $_GET['core'];
    if (!isset($core) || !in_array($core, $cores)) {
      $core = 'cerl';
    }

    $url = 'http://localhost:8983/solr/' . $core . '/select?' . join('&', $params);
    $response = json_decode(file_get_contents($url));
    // $response = json_decode(curl_get_file_contents($url));

    return $response;
  }
  return NULL;
}

function curl_get_file_contents($URL) {
  $c = curl_init();
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($c, CURLOPT_URL, $URL);
  $contents = curl_exec($c);
  curl_close($c);

  if ($contents)
    return $contents;

  return FALSE;
}