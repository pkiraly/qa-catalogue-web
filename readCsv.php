<?php
require_once 'common-functions.php';
$db = getOrDefault('db', 'cerl');
$filename = getOrDefault('file', '', ['authorities-histogram', 'classifications-histogram']);

error_log('filename: ' . $filename);

if ($filename != '') {
  $configuration = parse_ini_file("configuration.cnf");
  $dir = $configuration['dir'];
  $absoluteFilePath = sprintf('%s/%s/%s.csv', $dir, $db, $filename);
  if (file_exists($absoluteFilePath)) {
    echo file_get_contents($absoluteFilePath);
  }
}
