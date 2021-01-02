<?php
set_time_limit(0);

require_once 'common-functions.php';
$marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';

$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$display = getOrDefault('display', 0);

$configuration = parse_ini_file("configuration.cnf");

$categories = readCategories();
$types = readTypes();
foreach ($types as $type) {
  if (!isset($categories[$type->categoryId]->types))
    $categories[$type->categoryId]->types = [];
  $categories[$type->categoryId]->types[] = $type->id;
  $type->variants = [];
  $type->variantCount = 0;
}

// $display = TRUE;
$elementsFile = sprintf('%s/%s/issue-summary.csv', $configuration['dir'], $db);
$records = [];
$max = 0;
$total = 0;
if (file_exists($elementsFile)) {
  // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
  // control subfield: invalid value
  $lineNumber = 0;
  $header = [];

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
      $typeId = $record->typeId;
      unset($record->categoryId);
      unset($record->typeId);
      unset($record->type);
      $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);
      if (!isset($records[$typeId])) {
        $records[$typeId] = [];
      }
      if ($typeId == 9) { // 'undefined field'
        $records[$typeId][] = $record;
      } else if (count($records[$typeId]) < 100) {
        $records[$typeId][] = $record;
      }
      $types[$typeId]->variantCount++;
    }
  }

  if ($display == 1) {
    $smarty->assign('records', $records);
    $smarty->assign('categories', $categories);
    $smarty->assign('types', $types);
    $smarty->assign('topStatistics', readTotal());
    $smarty->assign('total', $total);
    $smarty->assign('fieldNames', ['path', 'message', 'url', 'instances', 'records']);
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
    // 'typeCounter' => $typeCounter
  ]);
}

function showMarcUrl($content) {
  global $marcBaseUrl;

  if (!preg_match('/^http/', $content))
    $content = $marcBaseUrl . $content;

  return $content;
}

function readCategories() {
  return readIssueCsv('issue-by-category.csv', 'id');
}

function readTypes() {
  return readIssueCsv('issue-by-type.csv', 'id');
}

function readTotal() {
  global $total;
  $statistics = readIssueCsv('issue-total.csv', 'type');
  foreach ($statistics as $item)
    if ($item->type != 2)
      $total += $item->records;

  foreach ($statistics as &$item)
    $item->percent = ($item->records / $total) * 100;

  if (!isset($statistics["0"]))
    $statistics["0"] = (object)[
      "type" => "0",
  		"instances" => "0",
	  	"records" => "0",
		  "percent" => 0
    ];

  return $statistics;
}

function readIssueCsv($filename, $keyField) {
  global $configuration, $db;

  $elementsFile = sprintf('%s/%s/%s', $configuration['dir'], $db, $filename);
  return reacCsv($elementsFile, $keyField);
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