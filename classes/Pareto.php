<?php


class Pareto extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('files', $this->listFiles());
  }

  public function getTemplate() {
    return 'pareto.tpl';
  }

  private function listFiles() {
    $files = [];
    $byRecordsFile = $this->getFilePath('marc-elements.csv');
    if (file_exists($byRecordsFile)) {
      $raw_files = scandir(sprintf('images/%s', $this->id));
      foreach ($raw_files as $file)
        if (preg_match('/^frequency-.*\.png$/', $file))
          $files[] = $file;
    }
    return $files;
  }
}