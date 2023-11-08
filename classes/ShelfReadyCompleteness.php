<?php


class ShelfReadyCompleteness extends BaseTab {

  $this->parameterFile = 'shelf-ready-completeness.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readSRHistogram());
  }

  public function getTemplate() {
    return 'shelf-ready-completeness/shelf-ready-completeness.tpl';
  }

  private function readSRHistogram() {
    $fields = $this->readHistogram($this->getFilePath('shelf-ready-completeness-fields.csv'));
    foreach ($fields as $field) {
      $field->paths = explode(',', $field->marcpath);
    }

    return $fields;
  }

}