<?php
require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'cerl');
$configuration = parse_ini_file("configuration.cnf");

$result = new stdClass();
$result->byRecord = readByRecords($configuration['dir'], $db);
$result->byField = readByField($configuration['dir'], $db);

header('Content-Type: application/json');
echo json_encode($result);

function readByRecords($dir, $db) {
  global $smarty;

  $byRecordsFile = sprintf('%s/%s/classifications-by-records.csv', $dir, $db);
  if (file_exists($byRecordsFile)) {
    $header = [];
    $records = [];
    $in = fopen($byRecordsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        $records[] = (object)array_combine($header, $values);
      }
    }

    $smarty->assign('records', $records);
    return $smarty->fetch('classifications-by-records.tpl');
  }
  return NULL;
}

function readByField($dir, $db) {
  global $smarty;

  $byRecordsFile = sprintf('%s/%s/classifications-by-field.csv', $dir, $db);
  if (file_exists($byRecordsFile)) {
    $header = [];
    $records = [];
    $in = fopen($byRecordsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        $records[] = (object)array_combine($header, $values);
      }
    }

    $smarty->assign('records', $records);
    return $smarty->fetch('classifications-by-field.tpl');
  }
  return NULL;
}
