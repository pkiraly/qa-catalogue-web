<?php


class ShelfReadyCompleteness extends BaseTab {

  protected $parameterFile = 'shelf-ready-completeness.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readSRHistogram());
  }

  public function getTemplate() {
    return 'shelf-ready-completeness/shelf-ready-completeness.tpl';
  }

  private function readSRHistogram() {
    $fields = $this->readHistogram($this->getFilePath('shelf-ready-completeness-fields.csv'));
    foreach ($fields as $field) {
      $field->paths = explode(',', $field->marcpath);
    }

    return $fields;
  }

  public static function getHistogram($filepath) {
    global $general_log;
    $data = [];
    $header = [];
    $handle = fopen($filepath, "r");
    if ($handle) {
      $lineNumber = 0;
      while (($line = fgets($handle)) !== false) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
        } else {
          if (count($header) != count($values)) {
            $general_log->error(sprintf(
              'different number of columns in %s - line #%d: expected: %d vs actual: %d',
              $filepath, $lineNumber, count($header), count($values)));
            $general_log->error($line);
          }
          $entry = (object) array_combine($header, $values);
          
          $data[$entry->count] = $entry->frequency;
        }
      }
    }
    return $data;
  }

}
