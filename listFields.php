<?php
$url = 'http://localhost:8983/solr/gent';

$all_fields = file_get_contents($url . '/select/?select?q=*:*&wt=csv&rows=0');
$fields = explode(',', $all_fields);
sort($fields);

echo json_encode($fields);