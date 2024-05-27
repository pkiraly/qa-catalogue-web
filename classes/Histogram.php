<?php


class Histogram extends BaseTab {

  private $allowable_histograms = [
    'authorities-histogram' => ['name' => 'count', 'limit' => 30],
    'classifications-histogram' => ['name' => 'count', 'limit' => 30],
    'serial-histogram' => ['name' => 'score', 'limit' => 40],
    'tt-completeness-histogram-total' => ['name' => 'count', 'limit' => 40],
    'serial-score-histogram-total' => ['name' => 'count', 'limit' => 40],
  ];

  private $tt_completeness_suffixes = [
    'isbn', 'authors', 'alternative-titles', 'edition', 'contributors', 'series',
    'toc-and-abstract', 'date-008', 'date-26x', 'classification-lc-nlm',
    'classification-loc', 'classification-mesh', 'classification-fast',
    'classification-gnd', 'classification-other', 'online', 'language-of-resource',
    'country-of-publication', 'no-language-or-english', 'rda'
  ];

  private $serial_score_suffixes = [
    'date1-unknown', 'country-unknown', 'language', 'auth', 'enc-full', 'enc-mlk7',
    '006', '260', '264', '310', '336', '362', '588', 'no-subject', 'has-subject',
    'pcc', 'date1-0', 'abbreviated'
  ];

  private $shelf_ready_completeness_suffixes = [
    'LDR06', 'LDR07', 'LDR1718', 'TAG00600', 'TAG010', 'TAG015', 'TAG020', 'TAG035',
    'TAG040', 'TAG041', 'TAG050', 'TAG082', 'TAG1XX', 'TAG240', 'TAG245', 'TAG246',
    'TAG250', 'TAG264', 'TAG300', 'TAG336', 'TAG337', 'TAG338', 'TAG490', 'TAG500',
    'TAG504', 'TAG505', 'TAG520', 'TAG546', 'TAG588', 'TAG6XX', 'TAG7XX', 'TAG776',
    'TAG856', 'TAG8XX', 'total'
  ];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->output = 'none';

    $this->prepare();
    $filename = getOrDefault('file', '', array_keys($this->allowable_histograms));
    $this->read($filename);
  }

  public function getTemplate() {
    return 'history.tpl';
  }

  private function prepare() {
    foreach ($this->tt_completeness_suffixes as $suffix) {
      $this->allowable_histograms['tt-completeness-histogram-' . $suffix] = [
        'name' => 'count', 'limit' => 10
      ];
    }


    foreach ($this->serial_score_suffixes as $suffix) {
      $this->allowable_histograms['serial-score-histogram-' . $suffix] = [
        'name' => 'count', 'limit' => 10
      ];
    }

    foreach ($this->shelf_ready_completeness_suffixes as $suffix) {
      $this->allowable_histograms['shelf-ready-completeness-histogram-' . $suffix] = [
        'name' => 'count', 'limit' => 50
      ];
      if ($suffix == 'total') {
        $this->allowable_histograms['shelf-ready-completeness-histogram-total']['buckets'] = 'round';
      }
    }
  }

  private function read($filename) {
    if ($filename == '') {
      return;
    }
    $absoluteFilePath = $this->getFilePath($filename . '.csv');
    $limit = $this->allowable_histograms[$filename]['limit'];
    $field_name = $this->allowable_histograms[$filename]['name'];
    if (isset($this->allowable_histograms[$filename]['buckets'])) {
      $method = $this->allowable_histograms[$filename]['buckets'];
      $buckets = [];
    } else {
      $method = FALSE;
    }
    if (!file_exists($absoluteFilePath)) {
      return;
    }
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
        if ($method == 'round') {
          $round = (string) (round($record->{$field_name} * 2) / 2);
          if (!isset($buckets[$round]))
            $buckets[$round] = 0;
          $buckets[$round] += $record->frequency;
        } elseif ($record->{$field_name} >= $limit) {
          $lastBucket += $record->frequency;
        } else {
          $content .= $line;
        }
      }
    }
    if ($method == 'round') {
      foreach ($buckets as $round => $frequency) {
        $content .= "$round,$frequency\n";
      }
    }

    if ($lastBucket != 0) {
      $content .= sprintf(
        "%s,%d\n",
        (($max > $limit) ? $limit . '-' . $max : $max),
        $lastBucket
      );
    }

    header("Content-type: text/csv");
    echo $content;
  }
}