<?php


class About extends BaseTab {

  public function prepareData(&$smarty) {
    $smarty->assign('db', $this->db);
  }

  public function getTemplate() {
    return 'about.tpl';
  }
}