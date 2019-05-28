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

$solrResponse = getSolrResponse();
if (!is_null($solrResponse)) {
  $result = (object)[
    'numFound' => $solrResponse->response->numFound,
    'records' => getRecords($solrResponse),
    'facets' => getFacets($solrResponse)
  ];

  header('Content-Type: application/json');
  // echo '?(' . json_encode($result) . ')';
  echo json_encode($result);
}

function getRecords($solrResponse) {
  global $smarty;

  $smarty->assign('docs', $solrResponse->response->docs);
  $smarty->registerPlugin("function", "hasPublication", "hasPublication");
  $smarty->registerPlugin("function", "hasPhysicalDescription", "hasPhysicalDescription");
  $smarty->registerPlugin("function", "hasMainPersonalName", "hasMainPersonalName");
  $smarty->registerPlugin("function", "hasSimilarBooks", "hasSimilarBooks");
  $smarty->registerPlugin("function", "getFields", "getFields");
  $smarty->registerPlugin("function", "getMarcFields", "getMarcFields");
  return $smarty->fetch('marc-records.tpl');
}

function getFacets($solrResponse) {
  global $smarty;

  error_log(json_encode($solrResponse->facet_counts->facet_fields));

  $smarty->assign('facets', $solrResponse->facet_counts->facet_fields);
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
  $marc = json_decode($doc->record_sni[0]);
  // error_log($marc);

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

function getFields($doc) {
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

/**
 * Executes the Solr query and returns the JSON response.
 */
function getSolrResponse() {
  static $cores = ['cerl', 'cerl2', 'stanford', 'dnb', 'gent', 'szte'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $query = $_SERVER['QUERY_STRING'];

    error_log('$query: ' . $query);
    $params = ['indent=false'];
    $parts = explode('&', $query);
    foreach ($parts as $part) {
      if ($part == '')
        continue;

      list($k, $v) = explode('=', $part);
      if ($k == 'core' || $k == '_'  || $k == 'json.wrf' || $v == '') { //
        continue;
      }
      if (!preg_match('/%/', $v))
        $v = urlencode($v);
      $params[] = $k . '=' . $v;
    }

    $core = $_GET['core'];
    if (!isset($core) || !in_array($core, $cores)) {
      $core = 'cerl';
    }

    $url = 'http://localhost:8983/solr/' . $core . '/select?' . join('&', $params);
    $response = json_decode(file_get_contents($url));

    return $response;
  }
  return NULL;
}
