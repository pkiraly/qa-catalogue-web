<?php
require_once 'common-functions.php';

$db = getOrDefault('db', 'metadata-qa');

$configuration = parse_ini_file("configuration.cnf");

$elementsFile = sprintf('%s/%s/functional-analysis-histogram.csv', $configuration['dir'], $db);
$records = [];
$types = [];
$max = 0;
if (file_exists($elementsFile)) {
  $lineNumber = 0;
  $header = [];
  $in = fopen($elementsFile, "r");
  $groupped_csv = [];
  while (($line = fgets($in)) != false) {
    $lineNumber++;
    $values = str_getcsv($line);
    if ($lineNumber == 1) {
      // frbrfunction, score, count
      $header = $values;
      $current_function = '';
      $function_report = [];
      $groupped_csv[] = $header;
    } else {
      if (count($header) != count($values)) {
        error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
      }
      $record = (object)array_combine($header, $values);
      if ($record->frbrfunction != $current_function) {
        if ($current_function != '') {
          add_function_report($current_function, $function_report, $groupped_csv);
        }
        $function_report = [];
        $current_function = $record->frbrfunction;
      }

      $rounded = round($record->score * 100);
      if (!isset($function_report[$rounded])) {
        $function_report[$rounded] = $record->count;
      } else {
        $function_report[$rounded] += $record->count;
      }
    }
  }
  add_function_report($current_function, $function_report, $groupped_csv);
  fclose($in);

  header("Content-type: text/csv");
  echo format_as_csv($groupped_csv);
}

function add_function_report($current_function, $function_report, &$groupped_csv) {
  foreach ($function_report as $score => $count) {
    $groupped_csv[] = [$current_function, $score, $count];
  }
}

function format_as_csv($groupped_csv) {
  $lines = [];
  foreach ($groupped_csv as $row) {
    $lines[] = join(',', $row);
  }
  return join("\n", $lines);
}
