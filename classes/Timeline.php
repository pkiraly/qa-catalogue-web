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

    $smarty->assign('versions', $this->getVersions());
    $smarty->assign('counts', $this->readCounts());
    $smarty->assign('totals', $this->readTotal());

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
    }
    return $totals;
  }
}