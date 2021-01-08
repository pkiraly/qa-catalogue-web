<?php


class Serials extends BaseTab {

  public function prepareData(&$smarty) {
    $smarty->assign('fields', $this->readSerialHistogram());
    $smarty->assign('db', $this->db);
  }

  public function getTemplate() {
    return 'serials.tpl';
  }

  private function readSerialHistogram() {
    return $this->readHistogram($this->getFilePath('serial-score-fields.csv'));
  }
}