<?php
set_time_limit(0);
require_once 'common-functions.php';

$marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';

$db = getOrDefault('db', 'cerl');
$id = getOrDefault('id', null);
$display = getOrDefault('display', 0);

$configuration = parse_ini_file("configuration.cnf");

// $display = TRUE;
$elementsFile = sprintf('%s/%s/issue-details.csv', $configuration['dir'], $db);
$types = [];
$max = 0;
$issues = [];
if (!file_exists($elementsFile)) {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
} else {
  // $keys = ['recordId', 'MarcPath', 'type', 'message', 'url'];
  $lineNumber = 0;
  $header = [];
  $typeCounter = [];

  $handle = fopen($elementsFile, "r");
  if ($handle) {
    $already_found = false;
    while (($line = fgets($handle)) !== false) {
      // process the line read.
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
        // error_log(gettype($record->recordId) . ' vs ' . gettype($id));
        if ($record->recordId == $id) {
          $type = $record->type;
          unset($record->type);
          unset($record->recordId);
          $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);
          if (!isset($issues[$type])) {
            $issues[$type] = [];
          }
          $issues[$type][] = $record;
          if (!isset($typeCounter[$type])) {
            $typeCounter[$type] = (object)[
              'count' => 0,
              'variations' => 0
            ];
          }
          $typeCounter[$type]->count++;
          $typeCounter[$type]->variations++;
          $already_found = true;
        } else {
          if ($already_found)
            break;
        }
      }
    }
    fclose($handle);
  } else {
    // error opening the file.
  }

  $types = array_keys($issues);
  /*
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
  */
}

if ($display == 1) {
  $smarty = createSmarty('templates');
  $smarty->assign('issues', $issues);
  $smarty->assign('types', $types);
  // $smarty->assign('types', $typesOrdered);
  $smarty->assign('fieldNames', ['path', 'message', 'url', 'count']);
  $smarty->assign('typeCounter', $typeCounter);
  $smarty->registerPlugin("function", "showMarcUrl", "showMarcUrl");
  $html = $smarty->fetch('record-issues.tpl');
  echo $html;
} else {
  header("Content-type: application/json");
  echo json_encode([
    'issues' => $issues,
    // 'types' => $typesOrdered,
    'types' => $types,
    'typeCounter' => $typeCounter
  ]);
}

function showMarcUrl($content) {
  global $marcBaseUrl;

  if (!preg_match('/^http/', $content))
    $content = $marcBaseUrl . $content;

  return $content;
}
