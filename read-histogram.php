<?php
require_once 'common-functions.php';
$db = getOrDefault('db', 'cerl');
$filename = getOrDefault('file', '', ['authorities-histogram', 'classifications-histogram']);

if ($filename != '') {
  $configuration = parse_ini_file("configuration.cnf");
  $dir = $configuration['dir'];
  $absoluteFilePath = sprintf('%s/%s/%s.csv', $dir, $db, $filename);
  if (file_exists($absoluteFilePath)) {
    $content = '';
    $max = 0;
    $lastBucket = 0;
    $in = fopen($absoluteFilePath, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
        $content .= $line;
      } else {
        $record = (object)array_combine($header, $values);
        $max = $record->count;
        if ($record->count >= 30) {
          $lastBucket += $record->frequency;
        } else {
          $content .= $line;
        }
      }
    }
    if ($lastBucket != 0) {
      $content .= sprintf(
        "%s,%d\n",
        (($max > 30) ? 30 . '-' . $max : $max),
        $lastBucket
      );
    }
    echo $content;
  }
}
