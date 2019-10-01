<?php
require_once 'common-functions.php';
static $cores = ['cerl', 'cerl2', 'stanford', 'dnb', 'gent', 'szte', 'mokka', 'loc', 'mtak', 'bayern'];

$db = getPostedOrDefault('db', 'cerl');
$facet = getPostedOrDefault('facet', '');
$configuration = parse_ini_file("configuration.cnf");

if (!in_array($db, $cores)) {
  echo json_encode(FALSE);
} else {
  $url = 'http://localhost:8983/solr/' . $db;
  $all_fields = file_get_contents($url . '/select/?q=*:*&wt=csv&rows=0');
  $fields = explode(',', $all_fields);

  // $selectedFacets = explode(',', htmlspecialchars($_POST["facet"]));
  $selectedFacets = explode(',', htmlspecialchars($facet));

  $checkedFacets = [];
  foreach ($selectedFacets as $facet) {
    if (in_array($facet, $fields))
      $checkedFacets[] = $facet;
  }

  $content = sprintf("var selectedFacets = ['%s'];", join("','", $checkedFacets));
  $success = file_put_contents('cache/selected-facets-' . $db . '.js', $content);

  echo json_encode($success);
}
