<?php

require_once 'Issues.php';
require_once 'Completeness.php';
require_once 'AddedEntry.php';
require_once 'Authorities.php';

class Start extends BaseTab {

  public function getTemplate() {
    return 'start/start.tpl';
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('issueStats', Issues::readTotal($this->getFilePath('issue-total.csv'), $this->count));
    $smarty->assign('fields', json_encode(Start::readCompleteness('all', $this->getFilePath('marc-elements.csv'), $this->getFilePath('packages.csv'))));
    $smarty->assign('authorities', Authorities::readByRecords($this->getFilePath('authorities-by-records.csv'), $this->count));
  }

  public static function readCompleteness($type, $elementsFile, $packageFile, $groupId = null) {
    $records = [];
    if (file_exists($elementsFile)) {
      error_log('completeness file: ' . $elementsFile);
      $start = microtime(true);
      $lineNumber = 0;
      $header = [];

      $handle = fopen($elementsFile, "r");
      if ($handle) {
        while (($line = fgets($handle)) !== false) {
          $lineNumber++;
          $values = str_getcsv($line);
          if ($lineNumber == 1) {
            $header = $values;
          } else {
            if (count($header) != count($values)) {
              error_log(sprintf('different number of columns in %s - line #%d: expected: %d vs actual: %d',
                $elementsFile, $lineNumber, count($header), count($values)));
              error_log($line);
            }
            $record = array_combine($header, $values);

            if (isset($record->documenttype) && $record->documenttype != $type)
              continue;

            if (!is_null($groupId) && $record->groupId != $groupId)
              continue;

            $records[$record["package"]][$record["tag"]][$record["subfield"]] = (object) [
              'count' => $record["number-of-record"],
            ];
          }
        }
        fclose($handle);
      } else {
        $msg = sprintf("file %s is not existing", $elementsFile);
        error_log($msg);
      }

      $lineNumber = 0;
      $handle = fopen($packageFile, "r");
      if ($handle) {
        while (($line = fgets($handle)) !== false) {
          $lineNumber++;
          $values = str_getcsv($line);
          if ($lineNumber == 1) {
            $header = $values;
          } else {
            if (count($header) != count($values)) {
              error_log(sprintf('different number of columns in %s - line #%d: expected: %d vs actual: %d',
                $elementsFile, $lineNumber, count($header), count($values)));
              error_log($line);
            }
            $record = array_combine($header, $values);

            if (isset($record->documenttype) && $record->documenttype != $type)
              continue;

            if (!is_null($groupId) && $record->groupId != $groupId)
              continue;

            $records[$record["label"]][""][""] = (object) [
              'count' => $record["count"],
            ];
          }
        }
        fclose($handle);
      } else {
        $msg = sprintf("file %s is not existing", $packageFile);
        error_log($msg);
      }
    }
    return $records;
  }
}
