<?php

require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");
$display = getOrDefault('display', 0);

$countFile = sprintf('%s/%s/count.csv', $configuration['dir'], $db);
$count = trim(file_get_contents($countFile));

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
    } else {
      if (count($header) != count($values)) {
        error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
        error_log($line);
      }
      $record = (object)array_combine($header, $values);
      if (isset($record->type) && $record->type != 'all')
        continue;

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

if ($display == 0) {
  header("Content-type: application/json");
  echo json_encode([
    'records' => $records,
    'max' => $max
  ]);
} else {
  $smarty->assign('records', $records);
  $smarty->assign('max', $max);

  $smarty->display('completeness.tpl');
}

