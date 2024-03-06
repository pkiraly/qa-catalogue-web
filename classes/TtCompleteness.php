<?php


class TtCompleteness extends BaseTab {

  protected $parameterFile = 'tt-completeness.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readTTHistogram());
  }

  public function getTemplate() {
    return 'tt-completeness/tt-completeness.tpl';
  }

  private function readTTHistogram() {
    $fields = $this->readHistogram($this->getFilePath('tt-completeness-fields.csv'));
    foreach ($fields as $field) {
      if (isset($field->fields))
        $field->paths = explode(',', $field->fields);
    }
    return $fields;
  }
}