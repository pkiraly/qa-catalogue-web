<?php


class ShelfReadyCompleteness extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readSRHistogram());
  }

  public function getTemplate() {
    return 'shelf-ready-completeness.tpl';
  }

  private function readSRHistogram() {
    return $this->readHistogram($this->getFilePath('shelf-ready-completeness-fields.csv'));
  }

}