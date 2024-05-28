<?php

class FunctionalAnalysisHistogram extends BaseTab {

  protected $selectedFunction;

  public function __construct($configuration, $id) {
    parent::__construct($configuration, $id);

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
    if (!file_exists($elementsFile)) {
      return;
    }
    $lineNumber = 0;
    $header = [];
    $currentFunction = '';
    $in = fopen($elementsFile, "r");
    $groupedCsv = [];
    while (($line = fgets($in)) != false) {
      $lineNumber++;
      $values = str_getcsv($line);
      if ($lineNumber == 1) {
        $header = $values;
        $function_report = [];
        if ($this->selectedFunction != '')
          $groupedCsv[] = ['count', 'frequency'];
        else
          $groupedCsv[] = ['frbrfunction', 'score', 'count'];
      } else {
        if (count($header) != count($values)) {
          error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
        }
        $record = (object)array_combine($header, $values);
        if ($this->selectedFunction != '' && $this->selectedFunction != $record->frbrfunction)
          continue;

        if ($record->frbrfunction != $currentFunction) {
          if ($currentFunction != '') {
            $this->addFunctionReport($currentFunction, $function_report, $groupedCsv);
          }
          $function_report = [];
          $currentFunction = $record->frbrfunction;
        }

        $rounded = $record->functioncount;
        if (!isset($function_report[$rounded])) {
          $function_report[$rounded] = $record->count;
        } else {
          $function_report[$rounded] += $record->count;
        }
      }
    }
    $this->addFunctionReport($currentFunction, $function_report, $groupedCsv);
    fclose($in);

    header("Content-type: text/csv");
    echo $this->formatAsCsv($groupedCsv);
  }

  private function addFunctionReport($current_function, $function_report, &$grouped_csv) {
    foreach ($function_report as $score => $count) {
      if ($this->selectedFunction != '')
        $grouped_csv[] = [$score, $count];
      else
        $grouped_csv[] = [$current_function, $score, $count];
    }
  }

  private function formatAsCsv($grouped_csv) {
    $lines = [];
    foreach ($grouped_csv as $row) {
      $lines[] = join(',', $row);
    }
    return join("\n", $lines);
  }
}
