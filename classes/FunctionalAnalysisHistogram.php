<?php


class FunctionalAnalysisHistogram extends BaseTab {

  protected $selectedFunction;

  public function __construct($configuration, $db) {
    parent::__construct($configuration, $db);

    $this->selectedFunction = getOrDefault('function', '');
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->output = 'none';
    $this->read('functional-analysis-histogram');
  }

  public function getTemplate() {
    return 'history.tpl';
  }

  private function read($filename) {
    $elementsFile = $this->getFilePath($filename . '.csv');
    if (file_exists($elementsFile)) {
      $lineNumber = 0;
      $header = [];
      $in = fopen($elementsFile, "r");
      $grouppedCsv = [];
      while (($line = fgets($in)) != false) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
          $currentFunction = '';
          $function_report = [];
          if ($this->selectedFunction != '')
            $grouppedCsv[] = ['count', 'frequency'];
          else
            $grouppedCsv[] = ['frbrfunction', 'score', 'count'];
        } else {
          if (count($header) != count($values)) {
            error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
          }
          $record = (object)array_combine($header, $values);
          if ($this->selectedFunction != '' && $this->selectedFunction != $record->frbrfunction)
            continue;

          if ($record->frbrfunction != $currentFunction) {
            if ($currentFunction != '') {
              $this->addFunctionReport($currentFunction, $function_report, $grouppedCsv);
            }
            $function_report = [];
            $currentFunction = $record->frbrfunction;
          }

          $rounded = round($record->score * 100);
          $rounded = $record->functioncount;
          if (!isset($function_report[$rounded])) {
            $function_report[$rounded] = $record->count;
          } else {
            $function_report[$rounded] += $record->count;
          }
        }
      }
      $this->addFunctionReport($currentFunction, $function_report, $grouppedCsv);
      fclose($in);

      header("Content-type: text/csv");
      echo $this->formatAsCsv($grouppedCsv);
    }
  }

  private function addFunctionReport($current_function, $function_report, &$groupped_csv) {
    foreach ($function_report as $score => $count) {
      if ($this->selectedFunction != '')
        $groupped_csv[] = [$score, $count];
      else
        $groupped_csv[] = [$current_function, $score, $count];
    }
  }

  private function formatAsCsv($groupped_csv) {
    $lines = [];
    foreach ($groupped_csv as $row) {
      $lines[] = join(',', $row);
    }
    return join("\n", $lines);
  }
}