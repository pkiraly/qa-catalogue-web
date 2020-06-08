<?php

require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");
$display = getOrDefault('display', 0);

$countFile = sprintf('%s/%s/count.csv', $configuration['dir'], $db);
$count = trim(file_get_contents($countFile));

$elementsFile = sprintf('%s/%s/packages.csv', $configuration['dir'], $db);
$hasNonCoreTags = FALSE;
$records = [];
$max = 0;
if (file_exists($elementsFile)) {
  // name,label,count
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
      $record->percent = $record->count * 100 / $count;
      if ($record->label == '') {
        $record->iscoretag = false;
      }
      if (isset($record->iscoretag) && $record->iscoretag === "true") {
        $record->iscoretag = true;
      } else {
        $hasNonCoreTags = TRUE;
        $record->iscoretag = false;
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
  $smarty->assign('hasNonCoreTags', $hasNonCoreTags);
  $smarty->display('packages.tpl');
}

