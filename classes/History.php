<?php


class History extends BaseTab {

  protected $parameterFile = 'completeness.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters();
    $smarty->assign('analysisTimestamp', $this->analysisParameters->analysisTimestamp);
    $this->grouped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);

    $smarty->assign('files', $this->listFiles());
  }

  public function getTemplate() {
    return 'history.tpl';
  }

  private function listFiles() {
    $files = [];
    $fileName = $this->grouped ? 'completeness-grouped-marc-elements.csv' : 'marc-elements.csv';
    $byRecordsFile = $this->getFilePath($fileName);
    error_log('byRecordsFile: ' . $byRecordsFile);
    if (file_exists($byRecordsFile)) {
      $raw_files = scandir(sprintf('images/%s', $this->id));
      foreach ($raw_files as $file)
        if (preg_match('/^marc-history\.png$/', $file))
          $files[] = $file;
    }
    return $files;
  }
}