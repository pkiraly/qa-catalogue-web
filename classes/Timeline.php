<?php


class Timeline extends BaseTab {

  private $hasNonCoreTags = FALSE;
  private $packages = [];
  private $packageIndex = [];
  private $records = [];
  private $types = [];
  private $type = 'all';
  private $max = 0;
  private static $supportedTypes = [
    'Books', 'Computer Files', 'Continuing Resources', 'Maps', 'Mixed Materials', 'Music', 'Visual Materials', 'all'
  ];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    // get version
    // $this->type = getOrDefault('type', 'all', self::$supportedTypes);

    $smarty->assign('versioning', $this->versioning);
    $smarty->assign('versions', $this->getVersions());
    $smarty->assign('counts', $this->readCounts());
    $smarty->assign('totals', $this->readTotal());
    $smarty->assign('byCategoryImage', $this->getByCategoryImage());
    $smarty->assign('byTypeImages', $this->getByTypeImages());
  }

  public function getTemplate() {
    return 'timeline.tpl';
  }

  private function readCounts() {
    $countFiles = $this->getHistoricalFilePaths('count.csv');
    $counts = [];
    foreach ($countFiles as $version => $countFile) {
      $counts[$version] = $this->readCount($countFile);
    }
    return $counts;
  }

  private function readTotal() {
    $counts = $this->readCounts();
    $totals = [];
    $issuesFiles = $this->getHistoricalFilePaths('issue-total.csv');
    $prevRecords = 0;
    $prevPercent = 0;
    foreach ($issuesFiles as $version => $file) {
      $count = $counts[$version];
      $totals[$version]['count'] = $count;
      $issuesTotals = readCsv($file, 'id');
      foreach ($issuesTotals as $item) {
        if ($item->type != 0) {
          $good = $count - $item->records;
          $totals[$version][$item->type] = [
            'good' => $count - $item->records,
            'goodPercent' => ($good / $count) * 100,
            'bad' => $item->records,
            'badPercent' => ($item->records / $count) * 100
          ];
        }
      }
      $totals[$version]['change'] = [
        'records' => $prevRecords == 0 ? 0 : $totals[$version][2]['good'] - $prevRecords,
        'percent' => $prevPercent == 0 ? 0 : $totals[$version][2]['goodPercent'] - $prevPercent
      ];
      $prevRecords = $totals[$version][2]['good'];
      $prevPercent = $totals[$version][2]['goodPercent'];
    }
    return $totals;
  }

  private function getByCategoryImage() {
    if (!is_null($this->historicalDataDir) && file_exists($this->historicalDataDir)) {
      $timelineFilename = 'timeline-by-category.png';
      if (file_exists(sprintf('images/%s/%s', $this->id, $timelineFilename))) {
        return $timelineFilename;
      }
    }
    return null;
  }

  private function getByTypeImages() {
    if (!is_null($this->historicalDataDir) && file_exists($this->historicalDataDir)) {
      $allFiles = scandir(sprintf('images/%s', $this->id));
      $files = [];
      $regex = '/^timeline-by-type-.*.png$/';
      foreach ($allFiles as $file)
        if (preg_match($regex, $file))
          $files[] = $file;

      return $files;
    }
    return null;
  }
}