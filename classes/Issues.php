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
  private $version;
  private $hiddenTypes = [];
  public $groups;
  public $currentGroup;

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters('validation.params.json');
    if ($this->versioning) {
      $versions = $this->getVersions();
      $smarty->assign('versions', $versions);
      $this->version = getOrDefault('version', $versions[count($versions)-1], $versions);
    }
    $smarty->assign('version', $this->version);

    $this->action = getOrDefault('action', 'list', ['list', 'query', 'download', 'record', 'ajaxIssue', 'ajaxIssueByTag']);
    error_log('action: ' . $this->action);
    $this->groupped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
    $smarty->assign('groupped', $this->groupped);
    $this->groupId = getOrDefault('groupId', 'all');
    $smarty->assign('groupId', $this->groupId);
    error_log('groupId: ' . $this->groupId);

    if ($this->groupped) {
      $this->groups = $this->readGroups();
      $this->currentGroup = $this->selectCurrentGroup();
      if (isset($this->currentGroup->count))
        $this->count = $this->currentGroup->count;
      $smarty->assign('currentGroup', $this->currentGroup);
      $smarty->assign('groups', $this->groups);
      $smarty->assign('params', [
        'action' => $this->action,
        'lang' => $this->lang
      ]);
    }

    if ($this->action == 'download' || $this->action == 'query') {
      $errorId = getOrDefault('errorId', '');
      $categoryId = getOrDefault('categoryId', '');
      $typeId = getOrDefault('typeId', '');
      if ($errorId != '' || $categoryId != '' || $typeId != '') {
        $this->output = 'none';
        if ($this->action == 'download')
          $this->download($errorId, $categoryId, $typeId);
        elseif ($this->action == 'query') {
          $this->query($errorId, $categoryId, $typeId);
        }
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
      if ($this->catalogue->getSchemaType() == 'PICA')
        $this->hiddenTypes = ['undefined field' => 1];
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
    return 'issues/issues.tpl';
  }

  public function getAjaxTemplate() {
    if ($this->action == 'ajaxIssueByTag')
      return 'issues/issue-by-tag.tpl';
    return 'issues/issue-list.tpl';
  }

  private function readIssues() {
    $lineNumber = 0;
    if ($this->versioning && $this->version != '') {
      $elementsFile = $this->getVersionedFilePath($this->version, 'issue-summary.csv');
    } else {
      $elementsFile = $this->getFilePath('issue-summary.csv');
    }
    if (file_exists($elementsFile)) {
      error_log('elementsFile: ' . $elementsFile);
      // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
      // control subfield: invalid value
      $header = [];

      foreach (file($elementsFile) as $line) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
          $i = ($this->groupped) ? 2 : 1;
          $header[$i] = 'path';
        } else {
          if (count($header) != count($values)) {
            error_log(sprintf('different number of columns in %s - line #%d: expected: %d vs actual: %d',
              $elementsFile, $lineNumber, count($header), count($values)));
          }
          $record = (object)array_combine($header, $values);

          if ($this->groupped && $record->groupId != $this->groupId)
            continue;

          $this->injectPica3($record);
          $typeId = $record->typeId;
          unset($record->categoryId);
          unset($record->typeId);
          unset($record->type);
          $record->ratio = $record->records / $this->count;
          $record->percent = $record->ratio * 100;

          $record->url = str_replace('https://www.loc.gov/marc/bibliographic/', '', $record->url);

          $record->downloadUrl = $this->downloadLink('errorId=' . $record->id);
          $record->queryUrl = $this->queryLink('errorId:' . $record->id);

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
    if ($this->sqliteExists())
      $this->readIssuesAjaxDB($categoryId, $typeId, $path, $order, $page, $limit);
    else
      $this->readIssuesAjaxCSV($categoryId, $typeId, $path, $order, $page, $limit);
  }

  private function readIssuesAjaxCSV($categoryId, $typeId, $path = null, $order = 'records DESC', $page = 0, $limit = 100) {
    $this->readIssuesAjaxDB($categoryId, $typeId, $page, $limit);
    $lineNumber = 0;
    if ($this->versioning && $this->version != '') {
      $elementsFile = $this->getVersionedFilePath($this->version, 'issue-summary.csv');
    } else {
      $elementsFile = $this->getFilePath('issue-summary.csv');
    }
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
  }

  private function readIssuesAjaxDB($categoryId, $typeId, $path = null, $order = 'records DESC', $page = 0, $limit = 100) {
    error_log('readIssuesAjaxDB()');
    include_once 'IssuesDB.php';
    $db = new IssuesDB($this->getDbDir());
    $groupId = $this->groupped ? $this->groupId : '';
    if (is_null($path) || empty($path)) {
      $this->recordCount = $db->getByCategoryTypeAndGroupCount($categoryId, $typeId, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getByCategoryTypeAndGroup($categoryId, $typeId, $groupId, $order, $page * $limit, $limit);
    } else {
      $this->recordCount = $db->getByCategoryTypePathAndGroupCount($categoryId, $typeId, $path, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getByCategoryTypePathAndGroup($categoryId, $typeId, $path, $groupId, $order, $page * $limit, $limit);
    }

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $record = (object) $row;
      $this->processRecord($record);
      $this->records[] = $record;
    }
    $this->pages = $this->createPages($this->recordCount);
  }

  private function readIssuesAjaxByTag($categoryId, $typeId, $order = 'records DESC', $page = 0, $limit = 100) {
    include_once 'IssuesDB.php';
    $db = new IssuesDB($this->getDbDir());
    $groupId = $this->groupped ? $this->groupId : '';
    $this->recordCount = $db->getByCategoryAndTypeGrouppedByPathCount($categoryId, $typeId, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
    $result = $db->getByCategoryAndTypeGrouppedByPath($categoryId, $typeId, $groupId, $order, $page * $limit, $limit);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $record = (object) $row;
      $this->injectPica3($record);
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
    $record->downloadUrl = $this->downloadLink('errorId=' . $record->id);
    $record->queryUrl = $this->queryLink('errorId:' . $record->id);

    $this->injectPica3($record);
  }

  private function calculateRatio(&$record) {
    $record->ratio = $record->records / $this->count;
    $record->percent = $record->ratio * 100;
  }

  public static function showMarcUrl($content) {
    if (!preg_match('/^http/', $content))
      $content = BaseTab::$marcBaseUrl . $content;

    return $content;
  }

  private function readCategories() {
    if ($this->groupped) {
      $this->categories = $this->filterByGroup($this->readIssueCsv('issue-by-category.csv', ''), 'id');
      $total = $this->currentGroup->count;
    } else {
      $this->categories = $this->readIssueCsv('issue-by-category.csv', 'id');
      $total = $this->count;
    }
    foreach ($this->categories as $category) {
      $category->ratio = $category->records / $total;
      $category->percent = $category->ratio * 100;
    }
  }

  private function readTypes() {
    if ($this->groupped) {
      $this->types = $this->filterByGroup($this->readIssueCsv('issue-by-type.csv', ''), 'id');
      $total = $this->currentGroup->count;
    } else {
      $this->types = $this->readIssueCsv('issue-by-type.csv', 'id');
      $total = $this->count;
    }

    foreach ($this->types as $type) {
      if (!empty($this->hiddenTypes) && isset($this->hiddenTypes[$type->type]))
        continue;
      if (!isset($this->categories[$type->categoryId]->types))
        $this->categories[$type->categoryId]->types = [];
      $this->categories[$type->categoryId]->types[] = $type->id;
      $type->variants = [];
      $type->variantCount = 0;
      $type->ratio = $type->records / $total;
      $type->percent = $type->ratio * 100;
    }
  }

  private function readTotal() {
    if ($this->groupped) {
      $statistics = $this->filterByGroup($this->readIssueCsv('issue-total.csv', ''), 'type');
      $this->total = $this->currentGroup->count;
    } else {
      $statistics = $this->readIssueCsv('issue-total.csv', 'type');
      $this->total = $this->count;
    }

    foreach ($statistics as &$item) {
      $item->good = $this->total - $item->records;
      $item->goodPercent = ($item->good / $this->total) * 100;
      $item->bad = $item->records;
      $item->badPercent = ($item->bad / $this->total) * 100;
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

  public function readIssueCsv($filename, $keyField) {
    if ($this->versioning && $this->version != '') {
      $elementsFile = $this->getVersionedFilePath($this->version, $filename);
    } else {
      $elementsFile = $this->getFilePath($filename);
    }
    return readCsv($elementsFile, $keyField);
  }

  private function download($errorId, $categoryId, $typeId) {
    if ($errorId != '')
      $recordIds = $this->getIds($errorId, 'download');
    else if ($categoryId != '')
      $recordIds = $this->getIdsFromDB($categoryId, 'categoryId', 'download');
    else if ($typeId != '')
      $recordIds = $this->getIdsFromDB($typeId, 'typeId', 'download');

    $attachment = sprintf('attachment; filename="issue-%s-at-%s.csv"', $errorId, date("Y-m-d"));
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . $attachment);
    echo "Record ID\n", '"', join("\"\n\"", $recordIds), '"';
  }

  private function query($errorId, $categoryId, $typeId) {
    if ($errorId != '')
      $recordIds = $this->getIds($errorId, 'query');
    else if ($categoryId != '')
      $recordIds = $this->getIdsFromDB($categoryId, 'categoryId', 'query');
    else if ($typeId != '')
      $recordIds = $this->getIdsFromDB($typeId, 'typeId', 'query');

    $url = '?' . join('&', [
      'tab=data',
      'query=' . urlencode('id:("' . join('" OR "', $recordIds) . '")')
    ]);

    header('Location: ' . $url);
  }

  private function getIds($errorId, $action) {
    if ($this->sqliteExists())
      $recordIds = $this->getIdsFromDB($errorId, 'errorId', $action);
    else
      $recordIds = $this->getIdsFromCsv($errorId, $action);
    return $recordIds;
  }

  private function getIdsFromDB($id, $type, $action) {
    include_once 'IssuesDB.php';
    $db = new IssuesDB($this->getDbDir());

    $groupId = $this->groupped ? $this->groupId : '';
    if ($type == 'errorId')
      $result = $db->getRecordIdsByErrorId($id, $groupId);
    else if ($type == 'categoryId')
      $result = $db->getRecordIdsByCategoryId($id, $groupId);
    else if ($type == 'typeId')
      $result = $db->getRecordIdsByTypeId($id, $groupId);

    $recordIds = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $recordIds[] = $row['id'];
      if ($action == 'query' && count($recordIds) == $this->idLimit)
        break;
    }
    return $recordIds;
  }

  private function getIdsFromCsv($errorId, $action) {
    if ($this->versioning && $this->version != '') {
      $elementsFile = $this->getVersionedFilePath($this->version, 'issue-collector.csv');
    } else {
      $elementsFile = $this->getFilePath('issue-collector.csv');
    }
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

  private function getDbDir() {
    if ($this->versioning && $this->version != '') {
      $dir = sprintf('%s/_historical/%s/%s', $this->configuration['dir'], $this->getDirName(), $this->version);
    } else {
      $dir = sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
    }
    return $dir;
  }

  private function injectPica3(&$record) {
    if ($this->catalogue->getSchemaType() == 'PICA') {
      include_once 'SchemaUtil.php';
      SchemaUtil::initializeSchema($this->catalogue->getSchemaType());
      $definition = SchemaUtil::getDefinition($record->path);
      $pica3 = ($definition != null && isset($definition->pica3) ? '=' . $definition->pica3 : '');
      $record->withPica3 = $record->path . $pica3;
    }
  }

  private function filterByGroup($statistics, $key) {
    $filtered = [];
    foreach ($statistics as $record) {
      if ($this->groupped && $record->groupId != $this->groupId)
        continue;
      unset($record->groupId);
      $filtered[$record->{$key}] = $record;
    }
    return $filtered;
  }

  /**
   * @param $query ('categoryId:$category->id'|, )
   * @return void
   */
  public function queryLink($query) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=data',
        'type=issues',
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if (isset($this->version) && !empty($this->version))
        $baseParams[] = 'version=' . $this->version;
      if (isset($this->groupId) && !empty($this->groupId))
        $baseParams[] = 'groupId=' . $this->groupId;
    }
    $params = $baseParams;
    $params[] = 'query=' . $query;
    return '?' . join('&', $params);
  }

  /**
   * @param $query (categoryId=<category->id>|typeId=<typeId>)
   * @return string
   */
  public function downloadLink($query) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=issues',
        'action=download',
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if (isset($this->version) && !empty($this->version))
        $baseParams[] = 'version=' . $this->version;
      if (isset($this->groupId) && !empty($this->groupId))
        $baseParams[] = 'groupId=' . $this->groupId;
    }
    $params = $baseParams;
    $params[] = $query;
    return '?' . join('&', $params);
  }

  public function sortLink($categoryId, $typeId, $path, $sort) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=issues',
        'ajax=1',
        'action=ajaxIssue',
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if (isset($this->version) && !empty($this->version))
        $baseParams[] = 'version=' . $this->version;
      if (isset($this->groupId) && !empty($this->groupId))
        $baseParams[] = 'groupId=' . $this->groupId;
    }
    $params = $baseParams;
    $params[] = 'categoryId=' . $categoryId;
    $params[] = 'typeId=' . $typeId;
    if (!is_null($path))
      $params[] = 'path=' . $path;
    $params[] = 'order=' . urlencode($sort);
    return '?' . join('&', $params);
  }

}
