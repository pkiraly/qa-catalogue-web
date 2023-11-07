<?php


class RecordIssues extends BaseTab {

  protected $recordId;
  protected $issues = [];
  protected $types = [];
  protected $typeCounter = [];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters('validation.params.json');
    $smarty->assign('analysisTimestamp', $this->analysisParameters->analysisTimestamp);
    error_log('analysisParameters: ' . json_encode($this->analysisParameters));
    $this->grouped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);

    $this->recordId = getOrDefault('recordId', '');
    if ($this->recordId != '') {
      $this->getRecordIssues();
    }

    $smarty->assign('issues', $this->issues);
    $smarty->assign('types', $this->types);
    $smarty->assign('fieldNames', ['path', 'message', 'url', 'count']);
    $smarty->assign('typeCounter', $this->typeCounter);
  }

  public function getTemplate() {
    return 'data/record-issues.tpl';
  }

  public function getAjaxTemplate() {
    return 'data/record-issues.tpl';
  }

  private function getRecordIssues() {
    $elementsFile = $this->getFilePath('issue-details.csv');
    $this->types = [];
    $this->issues = [];
    $this->typeCounter = [];
    if (!file_exists($elementsFile)) {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    } else {
      // $keys = ['recordId', 'MarcPath', 'type', 'message', 'url'];
      $lineNumber = 0;
      $header = [];

      $handle = fopen($elementsFile, "r");
      if ($handle) {
        $already_found = false;
        while (($line = fgets($handle)) !== false) {
          // process the line read.
          $lineNumber++;
          $values = str_getcsv($line);
          if ($lineNumber == 1) {
            $header = $values;
          } else {
            if (count($header) != count($values)) {
              error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
            }
            $record = (object)array_combine($header, $values);
            if ($record->recordId == $this->recordId) {
              $errors = [];
              $rawErrors = explode(';', $record->errors);
              foreach ($rawErrors as $rawError) {
                list($errorId, $count) = explode(':', $rawError);
                $errors[$errorId] = $count;
              }
              $issueDefinitions = $this->getIssueDefinitions(array_keys($errors));
              foreach ($issueDefinitions as $id => &$issue) {
                $issue->count = $errors[$errorId];
                if (!isset($this->issues[$issue->type])) {
                  $this->issues[$issue->type] = [];
                  $this->typeCounter[$issue->type] = 0;
                }
                $this->issues[$issue->type][] = $issue;
                $this->typeCounter[$issue->type] += $issue->count;
              }
              break;
            }
          }
        }
        fclose($handle);
      }
      $this->types = array_keys($this->issues);
    }
  }

  private function getIssueDefinitions($ids) {
    error_log('getIssueDefinitions for: ' . json_encode($ids) . ', groupped: ' . (int)$this->grouped);

    $issues = [];
    $file = $this->getFilePath('issue-summary.csv');
    error_log($file);

    if (file_exists($file)) {
      $header = [];
      $handle = fopen($file, "r");
      if ($handle) {
        while (($line = fgets($handle)) !== false) {
          $values = str_getcsv($line);
          if (empty($header)) {
            $header = $values;
            $i = ($this->grouped) ? 2 : 1;
            $header[$i] = 'path';
          } else {
            $record = (object)array_combine($header, $values);
            // if (!isset($record->id))
            //   error_log('no id ' . json_encode($record));
            if (isset($record->id) && in_array($record->id, $ids)) {
              $key = $record->id;
              unset($record->id);
              $issues[$key] = $record;
            }
          }
        }
      }
    }
    return $issues;
  }
}