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
$total = 0;
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
          'instances' => 0,
          'records' => 0,
          'variations' => 0
        ];
      }
      $typeCounter[$type]->instances += $record->instances;
      $typeCounter[$type]->records += $record->records;
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
    uasort($records[$type], 'issueCmp');
    error_log(json_encode($records[$type]));
  }
  $orderedCategories = ['record', 'control subfield', 'field', 'indicator', 'subfield'];
  $categories = [];
  foreach ($orderedCategories as $category) {
    if (isset($mainTypes[$category])) {
      asort($mainTypes[$category]);
      $categories[$category] = $mainTypes[$category];
    }
  }

  if ($display == 1) {
    $smarty->assign('records', $records);
    $smarty->assign('categories', $categories);
    $smarty->assign('topStatistics', readTotal());
    $smarty->assign('total', $total);
    $smarty->assign('typeStatistics', readTypes());
    $smarty->assign('categoryStatistics', readCategories());
    $smarty->assign('fieldNames', ['path', 'message', 'url', 'instances', 'records']);
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
    // 'types' => $typesOrdered,
    'typeCounter' => $typeCounter
  ]);
}

function showMarcUrl($content) {
  global $marcBaseUrl;

  if (!preg_match('/^http/', $content))
    $content = $marcBaseUrl . $content;

  return $content;
}

function readCategories() {
  return readIssueCsv('issue-by-category.csv', 'category');
}

function readTypes() {
  return readIssueCsv('issue-by-type.csv', 'type');
}

function readTotal() {
  global $total;
  $statistics = readIssueCsv('issue-total.csv', 'type');
  foreach ($statistics as $item) {
    if ($item->type != 2) {
      $total += $item->records;
    }
  }
  foreach ($statistics as &$item) {
    $item->percent = ($item->records / $total) * 100;
  }
  return $statistics;
}

function readIssueCsv($filename, $keyField) {
  global $configuration, $db;
  $elementsFile = sprintf('%s/%s/%s', $configuration['dir'], $db, $filename);
  $records = [];
  if (file_exists($elementsFile)) {
    $header = null;
    foreach (file($elementsFile) as $line) {
      $values = str_getcsv($line);
      if (is_null($header)) {
        $header = $values;
      } else {
        if (count($header) != count($values)) {
          error_log(count($header) . ' vs ' . count($values));
        }
        $record = (object)array_combine($header, $values);
        $key = $record->{$keyField};
        // unset($record->{$keyField});
        $records[$key] = $record;
      }
    }
  }
  return $records;
}

function issueCmp($a, $b) {
  $res = cmp($b->records, $a->records);
  if ($res == 0) {
    $res = cmp($a->path, $b->path);
  }
  return $res;
}

function cmp($a, $b) {
  if ($a == $b) {
    return 0;
  }
  return ($a < $b) ? -1 : 1;
}
