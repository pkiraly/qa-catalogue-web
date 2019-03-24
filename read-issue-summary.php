<?php
require_once 'common-functions.php';

$db = getOrDefault('db', 'cerl');

$configuration = parse_ini_file("configuration.cnf");

$elementsFile = sprintf('%s/%s/issue-summary.csv', $configuration['dir'], $db);
$records = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
  $lineNumber = 0;
  $header = [];
  foreach (file($elementsFile) as $line) {
    $lineNumber++;
    $values = str_getcsv($line);
    if ($lineNumber == 1) {
      $header = $values;
      $header[0] = 'path';
      error_log('header: ' . json_encode($header));
    } else {
      if ($lineNumber == 2)
        error_log(count($header) . ' vs ' . count($values));
      if (count($header) != count($values)) {
        error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
      }
      $record = (object)array_combine($header, $values);
      $type = $record->type;
      unset($record->type);
      if (!isset($records[$type])) {
        $records[$type] = [];
      }
      $records[$type][] = $record;
    }
  }
} else {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
}

header("Content-type: application/json");
echo json_encode([
  'records' => $records,
]);

