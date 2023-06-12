<?php

require_once 'DataFetch.php';

class Start extends BaseTab {

  public function getTemplate() {
    return 'start/start.tpl';
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('issueStats', DataFetch::readTotal($this->filePath('issue-total.csv'), $this->count));
  }
}
