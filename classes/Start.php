<?php

include 'Issues.php';

class Start extends BaseTab {

  public function getTemplate() {
    return 'start/start.tpl';
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('issueStats', $this->readTotal());
  }

  public function readIssueCsv($filename, $keyField) {
    if ($this->versioning && $this->version != '') {
      $elementsFile = $this->getVersionedFilePath($this->version, $filename);
    } else {
      $elementsFile = $this->getFilePath($filename);
    }
    return readCsv($elementsFile, $keyField);
  }

  private function readTotal() {
    if ($this->grouped) {
      $statistics = $this->filterByGroup($this->readIssueCsv('issue-total.csv', ''), 'type');
      $this->total = $this->currentGroup->count;
    } else {
      $statistics = $this->readIssueCsv('issue-total.csv', 'type');
      $this->total = $this->count;
    }

    foreach ($statistics as &$item) {
      $item->good = $this->total - $item->records;
      $item->goodPercent = ($item->good / $this->total) * 100;
      $item->bad = $item->records;
      $item->badPercent = ($item->bad / $this->total) * 100;
    }

    if (!isset($statistics["0"]))
      $statistics["0"] = (object)[
        "type" => "0",
        "instances" => "0",
        "records" => "0",
        "percent" => 0
      ];

    $complete = (object)[
      "good" => $statistics[1]->good,
      "unclear" => $statistics[2]->good - $statistics[1]->good,
      "bad" => $statistics[2]->bad
    ];

    return $complete;
  }
}
