<?php

$configuration = parse_ini_file("configuration.cnf");

$elementsFile = $configuration['dir'] . '/marc-elements.csv';
$records = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['element','number-of-record',number-of-instances,min,max,mean,stddev,histogram]; // "sum",
  $lineNumber = 0;
  $header = [];
  foreach (file($elementsFile) as $line) {
    $lineNumber++;
    $values = str_getcsv($line);
    if ($lineNumber == 1) {
      $header = $values;
      error_log('header: ' . json_encode($header));
    } else {
      $record = (object)array_combine($header, $values);
      $max = max($max, $record->{'number-of-record'});
      $record->mean = sprintf('%.2f', $record->mean);
      $record->stddev = sprintf('%.2f', $record->stddev);
      $histogram = new stdClass();
      foreach (explode('; ', $record->histogram) as $entry) {
        list($k,$v) = explode('=', $entry);
        $histogram->$k = $v;
      }
      $record->histogram = $histogram;
      $records[] = $record;
    }
  }
} else {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
}

header("Content-type: application/json");
echo json_encode([
  'records' => $records,
  'max' => $max
]);

