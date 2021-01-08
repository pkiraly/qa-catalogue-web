<?php


class ShelfReadyCompleteness extends BaseTab {

  public function prepareData(&$smarty) {
    $smarty->assign('fields', $this->readSRHistogram());
    $smarty->assign('db', $this->db);
  }

  public function getTemplate() {
    return 'shelf-ready-completeness.tpl';
  }

  private function readSRHistogram() {
    return $this->readHistogram($this->getFilePath('shelf-ready-completeness-fields.csv'));
  }

}