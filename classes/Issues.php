<?php


class Issues extends BaseTab {

  private $categories;
  private $types;
  private $records = [];
  private $total = 0;
  private $idLimit = 100;
  private $issueLimit = 100;
  private $action = 'list';
  private $recordCount;
  private $pages;
  private $categoryId;
  private $typeId;
  private $order;
  private $page;
  private $limit;
  private $listType;

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->action = getOrDefault('action', 'list', ['list', 'query', 'download', 'record', 'ajaxIssue', 'ajaxIssueByTag']);
    if ($this->action == 'download' || $this->action == 'query') {
      $errorId = getOrDefault('errorId', '');
      if ($errorId != '') {
        $this->output = 'none';
        if ($this->action == 'download')
          $this->download($errorId);
        elseif ($this->action == 'query')
          $this->query($errorId);
      }
    } elseif ($this->action == 'record') {
      $recordId = getOrDefault('recordId', '');
      if ($recordId != '') {
        $this->getRecordIssues($recordId, $smarty);
      }
    } elseif ($this->action == 'ajaxIssue') {
      $this->getAjaxParameters();
      $path = getOrDefault('path', null);
      $this->listType = is_null($path) ? 'full-list' : 'filtered-list';
      $this->readIssuesAjax($this->categoryId, $this->typeId, $path, $this->order, $this->page, $this->limit);
      $this->assignAjax($smarty);
      $smarty->assign('path', $path);
    } elseif ($this->action == 'ajaxIssueByTag') {
      $this->listType = 'gropupped-list';
      $this->getAjaxParameters();
      $this->readIssuesAjaxByTag($this->categoryId, $this->typeId, $this->order, $this->page, $this->limit);
      $this->assignAjax($smarty);
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
      $smarty->assign('listType', 'full-list');
      $smarty->assign('path', null);
      $smarty->registerPlugin("function", 'showMarcUrl', array('Issues', 'showMarcUrl'));
    }
  }

  public function getTemplate() {
    return 'issues.tpl';
  }

  public function getAjaxTemplate() {
    if ($this->action == 'ajaxIssueByTag')
      return 'issue-by-tag.tpl';
    return 'issue-list.tpl';
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
          } else if (count($this->records[$typeId]) < $this->issueLimit) {
            $this->records[$typeId][] = $record;
          }

          $this->types[$typeId]->variantCount++;
        }
      }
      foreach ($this->types as $typeId => $type) {
        $type->pages = $this->createPages($type->variantCount);
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
  }

  private function createPages($count) {
    $nrPages = ceil($count / $this->issueLimit);
    $pages = [];
    for ($i = 0; $i < $nrPages; $i++)
      $pages[] = $i;
    return $pages;
  }

  private function readIssuesAjax($categoryId, $typeId, $path = null, $order = 'records DESC', $page = 0, $limit = 100) {
    error_log('readIssuesAjax sqliteExists? ' . $this->sqliteExists());
    if ($this->sqliteExists())
      $this->readIssuesAjaxDB($categoryId, $typeId, $path, $order, $page, $limit);
    else
      $this->readIssuesAjaxCSV($categoryId, $typeId, $path, $order, $page, $limit);
  }

  private function readIssuesAjaxCSV($categoryId, $typeId, $path = null, $order = 'records DESC', $page = 0, $limit = 100) {
    $this->readIssuesAjaxDB($categoryId, $typeId, $page, $limit);
    $lineNumber = 0;
    $elementsFile = $this->getFilePath('issue-summary.csv');
    if (file_exists($elementsFile)) {
      // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
      // control subfield: invalid value
      $header = [];
      $count = 0;
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
          if (!($record->categoryId == $categoryId && $record->typeId == $typeId))
            continue;
          $count++;
          if ($count < ($page * $limit))
            continue;

          $this->processRecord($record);

          if (count($this->records) < $this->issueLimit) {
            $this->records[] = $record;
          }
        }
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
    error_log('records: ' . count($this->records));
  }

  private function readIssuesAjaxDB($categoryId, $typeId, $path = null, $order = 'records DESC', $page = 0, $limit = 100) {
    # install php7.4-sqlite3
    # sudo service apache2 restart
    include_once 'IssuesDB.php';
    $dir = sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
    $db = new IssuesDB($dir);
    if (is_null($path) || empty($path)) {
      $this->recordCount = $db->getByCategoryAndTypeCount($categoryId, $typeId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getByCategoryAndType($categoryId, $typeId, $order, $page * $limit, $limit);
    } else {
      $this->recordCount = $db->getByCategoryTypeAndPathCount($categoryId, $typeId, $path)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getByCategoryTypeAndPath($categoryId, $typeId, $path, $order, $page * $limit, $limit);
    }

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $record = (object) $row;
      $this->processRecord($record);
      $this->records[] = $record;
    }
    $this->pages = $this->createPages($this->recordCount);
  }

  private function readIssuesAjaxByTag($categoryId, $typeId, $order = 'records DESC', $page = 0, $limit = 100) {
    # install php7.4-sqlite3
    # sudo service apache2 restart
    include_once 'IssuesDB.php';
    $dir = sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
    $db = new IssuesDB($dir);
    $this->recordCount = $db->getByCategoryAndTypeGrouppedByPathCount($categoryId, $typeId)->fetchArray(SQLITE3_ASSOC)['count'];
    $result = $db->getByCategoryAndTypeGrouppedByPath($categoryId, $typeId, $order, $page * $limit, $limit);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $record = (object) $row;
      $this->calculateRatio($record);
      $this->records[] = $record;
    }
  }

  private function processRecord(&$record) {
    unset($record->categoryId);
    unset($record->typeId);
    unset($record->type);
    if (!isset($record->path)) {
      $record->path = $record->MarcPath;
    }
    $this->calculateRatio($record);
    $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);
    $record->downloadUrl = $this->getDownloadUrl($record);
    $record->queryUrl = $this->getQueryUrl($record);
  }

  private function calculateRatio(&$record) {
    $record->ratio = $record->records / $this->count;
    $record->percent = $record->ratio * 100;
  }

  private function getDownloadUrl($record) {
    return '?' . join('&', [
        'tab=' . 'issues',
        'errorId=' . $record->id,
        'action=download'
      ]);
  }

  private function getQueryUrl($record) {
    return '?' . join('&', ['tab=' . 'issues',
      'errorId=' . $record->id,
      'action=query']);
  }

  public static function showMarcUrl($content) {
    if (!preg_match('/^http/', $content))
      $content = BaseTab::$marcBaseUrl . $content;

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
    error_log($url);

    header('Location: ' . $url);
  }

  private function getIds($errorId, $action) {
    if ($this->sqliteExists())
      $recordIds = $this->getIdsFromDB($errorId, $action);
    else
      $recordIds = $this->getIdsFromCsv($errorId, $action);
    return $recordIds;
  }

  private function getIdsFromDB($errorId, $action) {
    # install php7.4-sqlite3
    # sudo service apache2 restart
    include_once 'IssuesDB.php';
    $dir = sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
    $db = new IssuesDB($dir);

    $result = $db->getRecordIdsByErrorId($errorId);
    $recordIds = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $recordIds[] = $row['id'];
      if ($action == 'query' && count($recordIds) == $this->idLimit)
        break;
    }
    return $recordIds;
  }

  private function getIdsFromCsv($errorId, $action) {
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
                $recordIds = array_slice($recordIds, 0, $this->idLimit);
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

  /**
   * @param Smarty $smarty
   */
  private function assignAjax(Smarty $smarty): void {
    $smarty->assign('categoryId', $this->categoryId);
    $smarty->assign('typeId', $this->typeId);
    $smarty->assign('records', $this->records);
    $smarty->assign('recordCount', $this->recordCount);
    $smarty->assign('pages', $this->pages);
    $smarty->assign('listType', $this->listType);
    $smarty->assign('order', $this->order);
  }

  private function getAjaxParameters(): void {
    $this->categoryId = getOrDefault('categoryId', -1);
    $this->typeId = getOrDefault('typeId', -1);
    $this->order = getOrDefault('order', 'records DESC');
    $this->page = getOrDefault('page', 0);
    $this->limit = getOrDefault('limit', $this->issueLimit);
  }
}
