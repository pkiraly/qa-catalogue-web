<?php


class TtCompleteness extends BaseTab {

  public function prepareData(&$smarty) {
    $smarty->assign('fields', $this->readTTHistogram());
    $smarty->assign('db', $this->db);
  }

  public function getTemplate() {
    return 'tt-completeness.tpl';
  }

  private function readTTHistogram() {
    return $this->readHistogram($this->getFilePath('tt-completeness-fields.csv'));
  }

}