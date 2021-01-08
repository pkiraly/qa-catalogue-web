<?php
require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");
$countFile = sprintf('%s/%s/tt-completeness.csv', $configuration['dir'], $db);
$solrFields = getSolrFields($db);

$result = new stdClass();
$result->histogram = readHistogram($configuration['dir'], $db);

header('Content-Type: application/json');
echo json_encode($result);

function readHistogram($dir, $db) {
  global $smarty;

  $byRecordsFile = sprintf('%s/%s/tt-completeness-fields.csv', $dir, $db);
  if (file_exists($byRecordsFile)) {
    $header = [];
    $records = [];
    $in = fopen($byRecordsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        $record = (object)array_combine($header, $values);
        if ($record->name != 'id' && $record->name != 'total')
          $records[] = $record;
      }
    }
    $smarty->assign('fields', $records);
    $smarty->assign('db', $db);
    return $smarty->fetch('tt-completeness-histogram.tpl');
  }
  return null;
}
