<?php
set_time_limit(0);

require_once 'common-functions.php';
$marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';

$smarty = createSmarty('templates');

$db = getOrDefault('db', 'cerl');
$display = getOrDefault('display', 0);

$configuration = parse_ini_file("configuration.cnf");

// $display = TRUE;
$elementsFile = sprintf('%s/%s/issue-summary.csv', $configuration['dir'], $db);
$records = [];
$types = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
  // control subfield: invalid value
  $lineNumber = 0;
  $header = [];
  $typeCounter = [];

  foreach (file($elementsFile) as $line) {
    $lineNumber++;
    $values = str_getcsv($line);
    if ($lineNumber == 1) {
      $header = $values;
      $header[1] = 'path';
    } else {
      if (count($header) != count($values)) {
        error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
      }
      $record = (object)array_combine($header, $values);
      $type = $record->type;
      unset($record->type);
      $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);
      if (!isset($records[$type])) {
        $records[$type] = [];
      }
      if (count($records[$type]) < 100) {
        $records[$type][] = $record;
      }
      if (!isset($typeCounter[$type])) {
        $typeCounter[$type] = (object)[
          'count' => 0,
          'variations' => 0
        ];
      }
      $typeCounter[$type]->count += $record->count;
      $typeCounter[$type]->variations++;
    }
  }

  $types = array_keys($records);
  $mainTypes = [];
  foreach ($types as $type) {
    list($mainType, $subtype) = explode(': ', $type);
    if (!isset($mainTypes[$mainType])) {
      $mainTypes[$mainType] = [];
    }
    $mainTypes[$mainType][] = $type;
  }
  $orderedMainTypes = ['record', 'control subfield', 'field', 'indicator', 'subfield'];
  $typesOrdered = [];
  foreach ($orderedMainTypes as $mainType) {
    if (isset($mainTypes[$mainType])) {
      asort($mainTypes[$mainType]);
      $typesOrdered = array_merge($typesOrdered, $mainTypes[$mainType]);
    }
  }

  if ($display == 1) {
    $smarty->assign('records', $records);
    $smarty->assign('types', $typesOrdered);
    $smarty->assign('fieldNames', ['path', 'message', 'url', 'count']);
    $smarty->assign('typeCounter', $typeCounter);
    $smarty->registerPlugin("function", "showMarcUrl", "showMarcUrl");
    $html = $smarty->fetch('issue-summary.tpl');
  }

} else {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
}

if ($display == 1) {
  echo $html;
} else {
  header("Content-type: application/json");
  echo json_encode([
    'records' => $records,
    'types' => $typesOrdered,
    'typeCounter' => $typeCounter
  ]);
}

function showMarcUrl($content) {
  global $marcBaseUrl;

  if (!preg_match('/^http/', $content))
    $content = $marcBaseUrl . $content;

  return $content;
}