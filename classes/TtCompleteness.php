<?php


class TtCompleteness extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readTTHistogram());
  }

  public function getTemplate() {
    return 'tt-completeness.tpl';
  }

  private function readTTHistogram() {
    return $this->readHistogram($this->getFilePath('tt-completeness-fields.csv'));
  }

}