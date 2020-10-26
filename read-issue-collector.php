<?php
require_once 'common-functions.php';

set_time_limit(300);
ini_set('memory_limit', '1G'); // or you could use 1024M


$db = getOrDefault('db', 'metadata-qa');
$errorId = getOrDefault('errorId', '');
$type = getOrDefault('type', '');
$path = getOrDefault('path', '');
$message = getOrDefault('message', '');
$limit = (int) getOrDefault('limit', 10);
$action = getOrDefault('action', 'query', ['query', 'download']);

$configuration = parse_ini_file("configuration.cnf");

$elementsFile = sprintf('%s/%s/issue-collector.csv', $configuration['dir'], $db);
$recordIds = [];
$types = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['errorId', 'recordIds']
  $lineNumber = 0;
  $header = [];
  $in = fopen($elementsFile, "r");
  while (($line = fgets($in)) != false) {
    if (count($recordIds) < 10) {
      $lineNumber++;
      if ($lineNumber == 1) {
        $header = str_getcsv($line);
      } else {
        if (preg_match('/^' . $errorId . ',/', $line)) {
          $values = str_getcsv($line);
          $record = (object)array_combine($header, $values);
          $recordIds = explode(';', $record->recordIds);
          if ($action == 'query')
            $recordIds = array_slice($recordIds, 0, $limit);
          break;
        }
      }
    }
  }
  fclose($in);
} else {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
}

if ($action == 'query') {
  header("Content-type: application/json");
  echo json_encode([
    'recordIds' => $recordIds
  ]);
} else if ($action == 'download') {
  $attachment = sprintf(
    'attachment; filename="issue-%s-at-%s.csv"',
    $errorId, date("Y-m-d"));

  header('Content-Type: application/csv; charset=utf-8');
  header('Content-Disposition: ' . $attachment);
  echo join("\n", $recordIds);
}