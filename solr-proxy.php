<?php

solr_proxy_main();

/**
 * Executes the Solr query and returns the JSON response.
 */
function solr_proxy_main() {
  static $cores = ['cerl', 'stanford', 'dnb', 'gent'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $query = $_SERVER['QUERY_STRING'];
    $core = $_GET['core'];

    if (!isset($core) || !in_array($core, $cores)) {
      $core = 'cerl';
    }
    $query = preg_replace('/&core=[^&]+/', '', $query);

    $response = file_get_contents('http://localhost:8983/solr/' . $core . '/select?' . $query . '&indent=false');

    header('Content-Type: application/json');
    echo $response;
  }
}
