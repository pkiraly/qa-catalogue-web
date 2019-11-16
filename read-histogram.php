<?php
require_once 'common-functions.php';
$db = getOrDefault('db', 'cerl');
$allowable_histograms = [
  'authorities-histogram' => ['name' => 'count', 'limit' => 30],
  'classifications-histogram' => ['name' => 'count', 'limit' => 30],
  'serial-histogram' => ['name' => 'score', 'limit' => 40],
  'tt-completeness-histogram-total' => ['name' => 'count', 'limit' => 40],
];

$tt_completeness_suffixes = [
  'transformed', 'isbn', 'authors', 'alternative-titles', 'edition', 'contributors',
  'series', 'toc', 'date-008', 'date-26x', 'lc-nlm', 'lo-c', 'mesh', 'fast', 'gnd',
  'other', 'online', 'language-of-resource', 'country-of-publication',
  'no-language-or-english', 'rda'
];

foreach ($tt_completeness_suffixes as $suffix) {
  $allowable_histograms['tt-completeness-histogram-' . $suffix] = [
    'name' => 'count', 'limit' => 10
  ];
}

$filename = getOrDefault('file', '', array_keys($allowable_histograms));

if ($filename != '') {
  $configuration = parse_ini_file("configuration.cnf");
  $dir = $configuration['dir'];
  $absoluteFilePath = sprintf('%s/%s/%s.csv', $dir, $db, $filename);
  $limit = $allowable_histograms[$filename]['limit'];
  $field_name = $allowable_histograms[$filename]['name'];
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
        $max = $record->{$field_name};
        if ($record->{$field_name} >= $limit) {
          $lastBucket += $record->frequency;
        } else {
          $content .= $line;
        }
      }
    }
    if ($lastBucket != 0) {
      $content .= sprintf(
        "%s,%d\n",
        (($max > $limit) ? $limit . '-' . $max : $max),
        $lastBucket
      );
    }
    echo $content;
  }
}
