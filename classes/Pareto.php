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
      $imageDir = $this->isDockerized() ? $this->getFilePath('img') : sprintf('images/%s', $this->id);
      if (file_exists($imageDir) && is_dir($imageDir)) {
        $raw_files = scandir($imageDir);
        foreach ($raw_files as $file) {
          if (preg_match('/^frequency-.*\.png$/', $file))
            $files[] = $this->isDockerized() ? $imageDir . '/' . $file : $file;
        }
      } else {
        $this->log->warning('no image dir found: ' . $imageDir);
      }
    }
    return $files;
  }
}