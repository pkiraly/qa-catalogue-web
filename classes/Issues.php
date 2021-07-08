<?php


class Issues extends BaseTab {

  private $categories;
  private $types;
  private $records = [];
  private $total = 0;
  private $limit = 10;

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $action = getOrDefault('action', 'list', ['list', 'query', 'download', 'record']);
    if ($action == 'download' || $action == 'query') {
      $errorId = getOrDefault('errorId', '');
      if ($errorId != '') {
        $this->output = 'none';
        if ($action == 'download')
          $this->download($errorId);
        elseif ($action == 'query')
          $this->query($errorId);
      }
    } elseif ($action == 'record') {
      $recordId = getOrDefault('recordId', '');
      if ($recordId != '') {
        $this->getRecordIssues($recordId, $smarty);
      }
    } else {
      $this->readCategories();
      $this->readTypes();
      $this->readIssues();

      $smarty->assign('records', $this->records);
      $smarty->assign('categories', $this->categories);
      $smarty->assign('types', $this->types);
      $smarty->assign('topStatistics', $this->readTotal());
      $smarty->assign('total', $this->count);
      $smarty->assign('fieldNames', ['path', 'message', 'url', 'instances', 'records']);
      $smarty->registerPlugin("function", 'showMarcUrl', array('Issues', 'showMarcUrl'));
    }
  }

  public function getTemplate() {
    return 'issues.tpl';
  }

  private function readIssues() {
    $lineNumber = 0;
    $elementsFile = $this->getFilePath('issue-summary.csv');
    if (file_exists($elementsFile)) {
      // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
      // control subfield: invalid value
      $header = [];

      foreach (file($elementsFile) as $line) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
          $header[1] = 'path';
        } else {
          if (count($header) != count($values)) {
            error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
          }
          $record = (object)array_combine($header, $values);
          $typeId = $record->typeId;
          unset($record->categoryId);
          unset($record->typeId);
          unset($record->type);
          $record->ratio = $record->records / $this->count;
          $record->percent = $record->ratio * 100;

          $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);

          $record->downloadUrl = '?' . join('&', [
            'tab=' . 'issues',
            'errorId=' . $record->id,
            'action=download'
          ]);

          $record->queryUrl = '?' . join('&', [
            'tab=' . 'issues',
            'errorId=' . $record->id,
            'action=query'
          ]);

          if (!isset($this->records[$typeId])) {
            $this->records[$typeId] = [];
          }

          if ($typeId == 9) { // 'undefined field'
            $this->records[$typeId][] = $record;
          } else if (count($this->records[$typeId]) < 100) {
            $this->records[$typeId][] = $record;
          }

          $this->types[$typeId]->variantCount++;
        }
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
  }

  public static function showMarcUrl($content) {
    if (!preg_match('/^http/', $content))
      $content = Issues::marcBaseUrl . $content;

    return $content;
  }

  private function readCategories() {
    $this->categories = $this->readIssueCsv('issue-by-category.csv', 'id');
    foreach ($this->categories as $category) {
      $category->ratio = $category->records / $this->count;
      $category->percent = $category->ratio * 100;
    }
  }

  private function readTypes() {
    $this->types = $this->readIssueCsv('issue-by-type.csv', 'id');

    foreach ($this->types as $type) {
      if (!isset($this->categories[$type->categoryId]->types))
        $this->categories[$type->categoryId]->types = [];
      $this->categories[$type->categoryId]->types[] = $type->id;
      $type->variants = [];
      $type->variantCount = 0;
      $type->ratio = $type->records / $this->count;
      $type->percent = $type->ratio * 100;
    }
  }

  private function readTotal() {
    $statistics = $this->readIssueCsv('issue-total.csv', 'type');
    $this->total = $this->count;
    /*
    foreach ($statistics as $item)
      if ($item->type != 2)
        $this->total += $item->records;
    */

    foreach ($statistics as &$item) {
      $item->good = $this->count - $item->records;
      $item->goodPercent = ($item->good / $this->count) * 100;
      $item->bad = $item->records;
      $item->badPercent = ($item->bad / $this->count) * 100;
    }

    if (!isset($statistics["0"]))
      $statistics["0"] = (object)[
          "type" => "0",
          "instances" => "0",
          "records" => "0",
          "percent" => 0
      ];

    return $statistics;
  }

  private function readIssueCsv($filename, $keyField) {
    $elementsFile = $this->getFilePath($filename);
    return readCsv($elementsFile, $keyField);
  }

  private function download($errorId) {
    $recordIds = $this->getIds($errorId, 'download');
    $attachment = sprintf('attachment; filename="issue-%s-at-%s.csv"', $errorId, date("Y-m-d"));

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . $attachment);
    echo "Record ID\n", '"', join("\"\n\"", $recordIds), '"';
  }

  private function query($errorId) {
    $recordIds = $this->getIds($errorId, 'query');
    $url = '?' . join('&', [
      'tab=data',
      'query=' . urlencode('id:("' . join('" OR "', $recordIds) . '")')
    ]);

    header('Location: ' . $url);
  }

  private function getIds($errorId, $action) {
    $elementsFile = $this->getFilePath('issue-collector.csv');
    $recordIds = [];
    if (file_exists($elementsFile)) {
      // $keys = ['errorId', 'recordIds']
      $lineNumber = 0;
      $header = [];
      $in = fopen($elementsFile, "r");
      while (($line = fgets($in)) != false) {
        if (count($recordIds) < 10) {
          $lineNumber++;
          if ($lineNumber == 1) {
            $header = str_getcsv($line);
          } else {
            if (preg_match('/^' . $errorId . ',/', $line)) {
              $values = str_getcsv(substr($line, 0, 10000));
              $record = (object)array_combine($header, $values);
              $recordIds = explode(';', $record->recordIds);
              if ($action == 'query')
                $recordIds = array_slice($recordIds, 0, $this->limit);
              break;
            }
          }
        }
      }
      fclose($in);
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
    return $recordIds;
  }
}