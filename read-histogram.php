<?php
require_once 'common-functions.php';
$db = getOrDefault('db', 'metadata-qa');
$allowable_histograms = [
  'authorities-histogram' => ['name' => 'count', 'limit' => 30],
  'classifications-histogram' => ['name' => 'count', 'limit' => 30],
  'serial-histogram' => ['name' => 'score', 'limit' => 40],
  'tt-completeness-histogram-total' => ['name' => 'count', 'limit' => 40],
  'serial-score-histogram-total' => ['name' => 'count', 'limit' => 40],
];

$tt_completeness_suffixes = [
  'isbn', 'authors', 'alternative-titles', 'edition', 'contributors', 'series',
  'toc-and-abstract', 'date-008', 'date-26x', 'classification-lc-nlm',
  'classification-loc', 'classification-mesh', 'classification-fast',
  'classification-gnd', 'classification-other', 'online', 'language-of-resource',
  'country-of-publication', 'no-language-or-english', 'rda'
];

foreach ($tt_completeness_suffixes as $suffix) {
  $allowable_histograms['tt-completeness-histogram-' . $suffix] = [
    'name' => 'count', 'limit' => 10
  ];
}

$serial_score_suffixes = [
  'date1-unknown', 'country-unknown', 'language', 'auth', 'enc-full', 'enc-mlk7',
  '006', '260', '264', '310', '336', '362', '588', 'no-subject', 'has-subject',
  'pcc', 'date1-0', 'abbreviated'
];

foreach ($serial_score_suffixes as $suffix) {
  $allowable_histograms['serial-score-histogram-' . $suffix] = [
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
