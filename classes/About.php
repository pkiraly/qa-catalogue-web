<?php


class About extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
  }

  public function getTemplate() {
    return 'about.tpl';
  }
}