<?php
require_once 'common-functions.php';

set_time_limit(300);

$db = getOrDefault('db', 'metadata-qa');
$errorId = getOrDefault('errorId', '');
$type = getOrDefault('type', '');
$path = getOrDefault('path', '');
$message = getOrDefault('message', '');

$configuration = parse_ini_file("configuration.cnf");

$elementsFile = sprintf('%s/%s/issue-details.csv', $configuration['dir'], $db);
$recordIds = [];
$types = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['recordId', 'MarcPath', 'type', 'message', 'url']
  $lineNumber = 0;
  $header = [];
  $in = fopen($elementsFile, "r");
  while (($line = fgets($in)) != false) {
    if (count($recordIds) < 10) {
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
        if ($record->path == $path
          && $record->type == $type
          && $record->message == $message) {
          $recordIds[] = $record->recordId;
        }
      }
    }
  }
  fclose($in);
} else {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
}

header("Content-type: application/json");
echo json_encode([
  'recordIds' => $recordIds
]);

