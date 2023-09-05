<?php

require_once 'Issues.php';
require_once 'Completeness.php';
require_once 'AddedEntry.php';
require_once 'Authorities.php';
require_once 'Classifications.php';
require_once 'ShelfReadyCompleteness.php';

class Start extends BaseTab {

  public function getTemplate() {
    return 'start/start.tpl';
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('issueStats', Issues::readTotal($this->getFilePath('issue-total.csv'), $this->count));
    $smarty->assign('fields', json_encode(Start::readCompleteness('all', $this->getFilePath('marc-elements.csv'), $this->getFilePath('packages.csv'))));
    $smarty->assign('authorities', Authorities::readByRecords($this->getFilePath('authorities-by-records.csv'), $this->count));
    $smarty->assign('classifications', Classifications::readByRecords($this->getFilePath('classifications-by-records.csv'), $this->count));

    $shelf_ready_completeness = ShelfReadyCompleteness::getHistogram($this->getFilePath("shelf-ready-completeness-histogram-total.csv"));
    $smarty->assign('shelf_ready_completeness', json_encode($shelf_ready_completeness));
  }

  public static function readCompleteness($type, $elementsFile, $packageFile, $groupId = null) {
    $records = [];
    $idDictionary = [];

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

            if (isset($record["documenttype"]) && $record["documenttype"] != $type)
              continue;

            if (!is_null($groupId) && $record->groupId != $groupId)
              continue;

            $path = explode("$", $record["path"], 2);
            if (count($path) == 1) {
              $path[1] = "";
              $name = $record["tag"];
            } else {
              $name = $record["subfield"];
            }

            $records[$record["packageid"]][$path[0]]['$'.$path[1]] = (object) [
              'count' => $record["number-of-record"],
              'name' => $name
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

            if (isset($record["documenttype"]) && $record["documenttype"] != $type)
              continue;

            if (!is_null($groupId) && $record->groupId != $groupId)
              continue;

            $records[$record["packageid"]][""][""] = (object) [
              'count' => $record["count"],
              'name' => $record["label"]
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

  public static function createHistogram($data, $bins) {
    $keys = array_keys($data);
    $min = min($keys);
    $max = max($keys);
    $delta = $max - $min;
    $bin_size = $delta / $bins;

    $output = [];

    for ($current_bin = $min + $bin_size; $current_bin <= $max; $current_bin += $bin_size) {
      $output[(string)$current_bin] = 0;
      foreach ($data as $key=>$value) {
        if ($key <= $current_bin && $key >= $current_bin - $bin_size) {
          $output[(string)$current_bin] = $output[(string)$current_bin] + $value;
        }
      }
    }

    return $output;
  }
}
