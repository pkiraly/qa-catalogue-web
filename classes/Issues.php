<?php


class Issues extends BaseTab {

  private $categories;
  private $types;
  private $records = [];
  private $total = 0;

  public function prepareData(&$smarty) {
    $this->readCategories();
    $this->readTypes();
    $this->readIssues();

    $smarty->assign('records', $this->records);
    $smarty->assign('categories', $this->categories);
    $smarty->assign('types', $this->types);
    $smarty->assign('topStatistics', $this->readTotal());
    $smarty->assign('total', $this->total);
    $smarty->assign('fieldNames', ['path', 'message', 'url', 'instances', 'records']);
    $smarty->registerPlugin("function", 'showMarcUrl', array('Issues', 'showMarcUrl'));
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
          $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);

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
  }

  private function readTypes() {
    $this->types = $this->readIssueCsv('issue-by-type.csv', 'id');

    foreach ($this->types as $type) {
      if (!isset($this->categories[$type->categoryId]->types))
        $this->categories[$type->categoryId]->types = [];
      $this->categories[$type->categoryId]->types[] = $type->id;
      $type->variants = [];
      $type->variantCount = 0;
    }
  }

  private function readTotal() {
    $statistics = $this->readIssueCsv('issue-total.csv', 'type');
    foreach ($statistics as $item)
      if ($item->type != 2)
        $this->total += $item->records;

    foreach ($statistics as &$item)
      $item->percent = ($item->records / $this->total) * 100;

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
}