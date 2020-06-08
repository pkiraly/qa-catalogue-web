<?php
require_once 'common-functions.php';

$db = getOrDefault('db', 'metadata-qa');
$url = 'http://localhost:8983/solr/' . $db;

$all_fields = file_get_contents($url . '/select/?q=*:*&wt=csv&rows=0');
$fields = explode(',', $all_fields);
sort($fields);

echo json_encode($fields);