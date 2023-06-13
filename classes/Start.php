<?php

require_once 'Issues.php';
require_once 'Completeness.php';

class Start extends BaseTab {

  public function getTemplate() {
    return 'start/start.tpl';
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('issueStats', Issues::readTotal($this->getFilePath('issue-total.csv'), $this->count));
    $smarty->assign('packages', Completeness::readPackages('all', $this->getFilePath('packages.csv')));
  }
}
