<?php
require_once 'common-functions.php';
$db = getOrDefault('db', 'cerl');
$filename = getOrDefault('file', '', ['authorities-histogram.csv']);

if ($filename != '') {
  $configuration = parse_ini_file("configuration.cnf");
  $dir = $configuration['dir'];
  $absoluteFilePath = sprintf('%s/%s/authorities-histogram.csv', $dir, $db);
  if (file_exists($absoluteFilePath)) {
    echo file_get_contents($absoluteFilePath);
  }
}
