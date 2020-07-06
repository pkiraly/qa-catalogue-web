<?php
require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");
$countFile = sprintf('%s/%s/shelf-ready-completeness.csv', $configuration['dir'], $db);

$result = new stdClass();
$result->histogram = readHistogram($configuration['dir'], $db);

header('Content-Type: application/json');
echo json_encode($result);

function readHistogram($dir, $db) {
  global $smarty;

  $byRecordsFile = sprintf('%s/%s/shelf-ready-completeness-fields.csv', $dir, $db);
  if (file_exists($byRecordsFile)) {
    $header = [];
    $records = [];
    $in = fopen($byRecordsFile, "r");
    $lineNr = 0;
    while (($line = fgets($in)) != false) {
      $lineNr++;
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        if (count($header) != count($values)) {
          error_log('error in line: ' . $lineNr);
          error_log('count header: ' . count($header));
          error_log('count values: ' . count($values));
        }
        $record = (object)array_combine($header, $values);
        $record->marcpath = str_replace(',', ', ', $record->marcpath);
        if ($record->name != 'id' && $record->name != 'total')
          $records[] = $record;
      }
    }
    $smarty->assign('fields', $records);
    $smarty->assign('db', $db);
    return $smarty->fetch('shelf-ready-completeness-histogram.tpl');
  }
  return null;
}
