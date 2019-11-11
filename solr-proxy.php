<?php

solr_proxy_main();

/**
 * Executes the Solr query and returns the JSON response.
 */
function solr_proxy_main() {
  static $cores = ['cerl', 'cerl2', 'stanford', 'dnb', 'gent', 'szte', 'mokka', 'loc', 'mtak', 'bayern', 'bnpl', 'nfi'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $query = $_SERVER['QUERY_STRING'];
    $parts = explode('&', $query);
    $params = [];
    foreach ($parts as $part) {
      list($k, $v) = explode('=', $part);
      if ($k == 'core' || $k == '_' || $v == '') { //  || $k == 'json.wrf'
        continue;
      }
      $params[] = $k . '=' . urlencode($v);
    }
    $params[] = 'indent=false';

    $core = $_GET['core'];
    if (!isset($core) || !in_array($core, $cores)) {
      $core = 'cerl';
    }

    $url = 'http://localhost:8983/solr/' . $core . '/select?' . join('&', $params);
    $response = file_get_contents($url);

    header('Content-Type: application/json');
    echo $response;
  }
}
