<?php


class Download extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->action = getOrDefault('action', 'list', ['list', 'download']);
    if ($this->action == 'download') {
      $files = [];
      foreach ($this->listFiles() as $cat => $f) {
        $files = array_merge($files, array_keys($f));
      }
      $file = getOrDefault('file', '', $files);
      if ($file != '') {
        $this->output = 'none';
        $this->downloadFile($file);
      }
    }

    $smarty->assign('categories', $this->listFiles());
  }

  public function getTemplate() {
    return 'download.tpl';
  }

  private function listFiles() {
    $categories = [
      'Completeness' => ['marc-elements.csv', 'packages.csv'],
      'Issues' => ['issue-by-category.csv', 'issue-by-type.csv', 'issue-summary.csv', 'issue-details.csv', 'issue-details-normalized.csv',
        'issue-total.csv', 'issue-collector.csv'],
      'Functional analysis' => ['functional-analysis.csv', 'functional-analysis-histogram.csv', 'functional-analysis-mapping.csv'],
      'Subject analysis' => ['classifications-by-records.csv', 'classifications-by-schema-subfields.csv', 'classifications-by-schema.csv',
        'classifications-collocations.csv', 'classifications-frequency-examples.csv', 'classifications-histogram.csv',
        'classifications-by-type.csv'],
      'Authorities' => ['authorities-by-categories.csv', 'authorities-by-records.csv', 'authorities-by-schema-subfields.csv',
        'authorities-by-schema.csv', 'authorities-frequency-examples.csv', 'authorities-histogram.csv'],
      'Serial scores' => ['serial-score.csv', 'serial-score-fields.csv', 'serial-histogram.csv'],
      'T&T completeness' => ['tt-completeness.csv', 'tt-completeness-fields.csv'],
      'Shelf-Ready completeness' => ['shelf-ready-completeness.csv', 'shelf-ready-completeness-fields.csv'],
      'History' => ['marc-history.csv'],
    ];
    $categories['Serial scores'] += $this->getSerialScoreHistograms();
    $categories['T&T completeness'] += $this->getTtCompletenessHistograms();
    $categories['Shelf-Ready completeness'] += $this->getShelfReadyCompletenessHistograms();

    foreach ($categories as $cat => $files) {
      $categories[$cat] = $this->getFileSize($files);
    }
    return $categories;
  }

  private function downloadFile($file) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . sprintf('attachment; filename="%s"', $file));
    readfile($this->getFilePath($file));
  }

  private function getFileSize(array $files) {
    $assoc = [];
    foreach ($files as $file) {
      $assoc[$file]['size'] = $this->humanFilesize(filesize($this->getFilePath($file)));
    }
    return $assoc;
  }

  // this function is modification of https://www.php.net/manual/en/function.filesize.php#106569
  private function humanFilesize($bytes, $decimals = 1) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    if ($factor == 0)
      return sprintf("%d", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
    else
      return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
  }

  private function getSerialScoreHistograms() {
    return $this->getFilenames('serial-score-histogram-.*.csv');
  }

  private function getTtCompletenessHistograms() {
    return $this->getFilenames('tt-completeness-histogram-.*.csv');
  }

  private function getShelfReadyCompletenessHistograms() {
    return $this->getFilenames('shelf-ready-completeness-histogram-.*.csv');
  }

  private function getFilenames($filter = '') {
    $dir = sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
    $allFiles = scandir($dir);
    $files = [];
    $regex = '/^' . $filter . '$/';
    foreach ($allFiles as $file)
      if (preg_match($regex, $file))
        $files[] = $file;

    return $files;
  }

}
