<?php
$url = 'http://localhost:8983/solr/gent';

$all_fields = file_get_contents($url . '/select/?select?q=*:*&wt=csv&rows=0');
$fields = explode(',', $all_fields);

$selectedFacets = explode(',', htmlspecialchars($_POST["facet"]));

$checkedFacets = [];
foreach ($selectedFacets as $facet) {
  if (in_array($facet, $fields))
    $checkedFacets[] = $facet;
}

$content = sprintf("var selectedFacets = ['%s'];", join("','", $checkedFacets));
$success = file_put_contents('selected-facets.js', $content);

echo json_encode($success);