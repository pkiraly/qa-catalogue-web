<?php
require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");

$result = new stdClass();
$result->histogram = readHistogram($configuration['dir'], $db);

header('Content-Type: application/json');
echo json_encode($result);

function readHistogram($dir, $db) {
  global $smarty;

  $byRecordsFile = sprintf('%s/%s/marc-elements.csv', $dir, $db);
  if (file_exists($byRecordsFile)) {
    $raw_files = scandir(sprintf('images/%s', $db));
    $files = [];
    foreach ($raw_files as $file) {
      if (preg_match('/^marc-history\.png$/', $file)) {
        $files[] = $file;
      }
    }
    $smarty->assign('db', $db);
    $smarty->assign('files', $files);
    return $smarty->fetch('history.tpl');
  }
  return null;
}
