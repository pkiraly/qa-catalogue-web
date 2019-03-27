<?php
require_once 'common-functions.php';

$db = getOrDefault('db', 'cerl');
$configuration = parse_ini_file("configuration.cnf");

$elementsFile = sprintf('%s/%s/marc-elements.csv', $configuration['dir'], $db);
$records = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['element','number-of-record',number-of-instances,min,max,mean,stddev,histogram]; // "sum",
  $lineNumber = 0;
  $header = [];

  $fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

  foreach (file($elementsFile) as $line) {
    $lineNumber++;
    $values = str_getcsv($line);
    if ($lineNumber == 1) {
      $header = $values;
      error_log('header: ' . json_encode($header));
    } else {
      if ($lineNumber == 2)
        error_log(count($header) . ' vs ' . count($values));
      if (count($header) != count($values)) {
        error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
        error_log($line);
      }
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

      list($tag, $subfield) = explode('$', $record->path);
      if (isset($fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr)) {
        $record->solr = $fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr . '_ss';
      } else {
        if (isset($fieldDefinitions->fields->{$tag}->solr)) {
          $record->solr = $tag . $subfield
                        . '_' . $fieldDefinitions->fields->{$tag}->solr
                        . '_' . $subfield . '_ss';
        }
      }

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

