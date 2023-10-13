<?php


class Serials extends BaseTab {

  protected $parameterFile = 'serials.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readSerialHistogram());
  }

  public function getTemplate() {
    return 'serials/serials.tpl';
  }

  private function readSerialHistogram() {
    return $this->readHistogram($this->getFilePath('serial-score-fields.csv'));
  }
}