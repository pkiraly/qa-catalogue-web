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
  public $groups;
  public $currentGroup;
  protected $parameterFile = 'validation.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    if ($this->versioning) {
      $versions = $this->getVersions();
      $smarty->assign('versions', $versions);
      $this->version = getOrDefault('version', $versions[count($versions)-1], $versions);
    }
    $smarty->assign('version', $this->version);

    $this->action = getOrDefault('action', 'list', ['list', 'query', 'download', 'record', 'ajaxIssue', 'ajaxIssueByTag']);
    $this->grouped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
    $smarty->assign('grouped', $this->grouped);
    $this->groupId = getOrDefault('groupId', 0);
    $smarty->assign('groupId', $this->groupId);

    if ($this->grouped) {
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
      $this->processDownloadOrQueryRequest();
    } elseif ($this->action == 'record') {
        $this->processRecordRequest($smarty);
    } elseif ($this->action == 'ajaxIssue') {
       $this->processAjaxIssueRequest($smarty);
    } elseif ($this->action == 'ajaxIssueByTag') {
       $this->processAjaxIssueByTagRequest($smarty);
    } else {
       $this->processListRequest($smarty);
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
      $header = [];

      $handle = fopen($elementsFile, "r");
      if ($handle) {
        while (($line = fgets($handle)) !== false) {
          $lineNumber++;
          $values = str_getcsv($line);
          if ($lineNumber == 1) {
            $header = $values;
            $i = ($this->grouped) ? 2 : 1;
            $header[$i] = 'path';
          } else {
            if (count($header) != count($values)) {
              error_log(sprintf('different number of columns in %s - line #%d: expected: %d vs actual: %d',
                $elementsFile, $lineNumber, count($header), count($values)));
            }
            $record = (object)array_combine($header, $values);

            if ($this->grouped && $record->groupId != $this->groupId)
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

  private function readIssuesAjaxDB($categoryId, $typeId, $path = null, $order = 'records DESC', $page = 0, $limit = 100) {
    $groupId = $this->grouped ? $this->groupId : '';
    if (is_null($path) || empty($path)) {
      $this->recordCount = $this->issueDB()->getByCategoryTypeAndGroupCount($categoryId, $typeId, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $this->issueDB()->getByCategoryTypeAndGroup($categoryId, $typeId, $groupId, $order, $page * $limit, $limit);
    } else {
      $this->recordCount = $this->issueDB()->getByCategoryTypePathAndGroupCount($categoryId, $typeId, $path, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $this->issueDB()->getByCategoryTypePathAndGroup($categoryId, $typeId, $path, $groupId, $order, $page * $limit, $limit);
    }

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $record = (object) $row;
      $this->processRecord($record);
      $this->records[] = $record;
    }
    $this->pages = $this->createPages($this->recordCount);
  }

  private function readIssuesAjaxByTag($categoryId, $typeId, $order = 'records DESC', $page = 0, $limit = 100) {
    $groupId = $this->grouped ? $this->groupId : '';

    // $this->recordCount = $db->getByCategoryAndTypeGroupedByPathCount($categoryId, $typeId, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
    if ($this->grouped) {
      $result = $this->issueDB()->getRecordNumberAndVariationsForPathGrouped($typeId, $groupId, $order, $page * $limit, $limit);
    } else {
      $result = $this->issueDB()->getByCategoryAndTypeGroupedByPath($categoryId, $typeId, $groupId, $order, $page * $limit, $limit);
    }
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
      $handle = fopen($elementsFile, "r");
      if ($handle) {
        while (($line = fgets($handle)) !== false) {
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
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
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
    if ($this->grouped) {
      $this->categories = Issues::filterByGroup($this->readIssueCsv('issue-by-category.csv', ''), 'id', $this->grouped, $this->groupId);
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
    if ($this->grouped) {
      $this->types = Issues::filterByGroup($this->readIssueCsv('issue-by-type.csv', ''), 'id', $this->grouped, $this->groupId);
      $total = $this->currentGroup->count;
    } else {
      $this->types = $this->readIssueCsv('issue-by-type.csv', 'id');
      $total = $this->count;
    }

    foreach ($this->types as $type) {
      if (!isset($this->categories[$type->categoryId]->types))
        $this->categories[$type->categoryId]->types = [];
      $this->categories[$type->categoryId]->types[] = $type->id;
      $type->variants = [];
      $type->variantCount = 0;
      $type->ratio = $type->records / $total;
      $type->percent = $type->ratio * 100;
    }
  }

  protected function filePath($filename) {
    if ($this->versioning && $this->version != '') {
      $elementsFile = $this->getVersionedFilePath($this->version, $filename);
    } else {
      $elementsFile = $this->getFilePath($filename);
    }
    
    return $elementsFile;
  }

  public static function readTotal($filepath, $total, $grouped = false, $group = null) {
    if (!is_null($group)) {
      $statistics = Issues::filterByGroup(readCsv($filepath, ''), 'type', $grouped, $group->id);
      $total = $group->count;
    } else {
      $statistics = readCsv($filepath, 'type');
    }

    foreach ($statistics as &$item) {
      $item->good = $total - $item->records;
      $item->goodPercent = ($item->good / $total) * 100;
      $item->bad = $item->records;
      $item->badPercent = ($item->bad / $total) * 100;
    }

    if (!isset($statistics["0"]))
      $statistics["0"] = (object)[
        "type" => "0",
        "instances" => "0",
        "records" => "0",
        "percent" => 0
      ];
      
      
    $result = (object)[
      "statistics" => $statistics,
      "summary" => (object)[
        "good" => $statistics[1]->good,
        "unclear" => $statistics[2]->good - $statistics[1]->good,
        "bad" => $statistics[2]->bad
      ]
    ];

    return $result;
  }

  public function readIssueCsv($elementsFile, $keyField) {
    return readCsv($this->filePath($elementsFile), $keyField);
  }

  private function download($errorId, $categoryId, $typeId) {
    $attachment = sprintf('attachment; filename="issue-%s-at-%s.csv"', $errorId, date("Y-m-d"));
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . $attachment);

    error_log('hasValidationIndex: ' . (int) $this->solr()->hasValidationIndex());
    if ($errorId != '') {
      if ($this->sqliteExists()) {
        $this->printId($this->getIdsFromDBResult($errorId, 'errorId', 'download'));
      } else {
        $recordIds = $this->getIdsFromCsv($errorId, $this->action);
        echo join("\n", $recordIds);
      }
    } else if ($categoryId != '') {
      $this->printId($this->getIdsFromDBResult($categoryId, 'categoryId', 'download'));
    } else if ($typeId != '') {
      $this->printId($this->getIdsFromDBResult($typeId, 'typeId', 'download'));
    }
  }

  private function printId($result) {
    while ($row = $result->fetchArray(SQLITE3_ASSOC))
      echo $row['id'], "\n";
  }


  private function query($errorId, $categoryId, $typeId) {
    if ($errorId != '')
      $recordIds = $this->getIds($errorId, 'query');
    else if ($categoryId != '')
      $recordIds = $this->getIdsFromDB($categoryId, 'categoryId', 'query');
    else if ($typeId != '')
      $recordIds = $this->getIdsFromDB($typeId, 'typeId', 'query');

    $params = array_merge([
      'tab=data',
      'query=' . urlencode('id:("' . join('" OR "', $recordIds) . '")')
    ], $this->getGeneralParams());
    $url = '?' . join('&', $params);

    header('Location: ' . $url);
  }

  private function getIds($errorId, $action) {
    if ($this->sqliteExists())
      $recordIds = $this->getIdsFromDB($errorId, 'errorId', $action);
    else
      $recordIds = $this->getIdsFromCsv($errorId, $action);
    return $recordIds;
  }

  private function getIdsFromDBResult($id, $type, $action): SQLite3Result {
    $groupId = $this->grouped ? $this->groupId : '';
    if ($type == 'errorId')
      $result = $this->issueDB()->getRecordIdsByErrorId($id, $groupId);
    else if ($type == 'categoryId')
      $result = $this->issueDB()->getRecordIdsByCategoryId($id, $groupId);
    else if ($type == 'typeId')
      $result = $this->issueDB()->getRecordIdsByTypeId($id, $groupId);
    else
      $result = false;

    return $result;
  }

  private function getIdsFromDB($id, $type, $action) {
    $result = $this->getIdsFromDBResult($id, $type, $action);

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

  protected function getDbDir() : string {
    if ($this->versioning && $this->version != '') {
      $dir = sprintf('%s/_historical/%s/%s', $this->configuration->getDir(), $this->configuration->getDirName(), $this->version);
    } else {
      $dir = sprintf('%s/%s', $this->configuration->getDir(), $this->configuration->getDirName());
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

  public static function filterByGroup($statistics, $key, $grouped = false, $groupId = null) {
    $filtered = [];
    foreach ($statistics as $record) {
      if ($grouped && $record->groupId != $groupId)
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

  public function sortIssuesLink($categoryId, $typeId, $path = null, $order = null, $page = null) {
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
    if (!is_null($order))
      $params[] = 'order=' . urlencode($order);
    if (!is_null($page))
      $params[] = 'page=' . $page;
    return '?' . join('&', $params);
  }

  public function issueByTagLink($categoryId, $typeId, $order = null) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=issues',
        'ajax=1',
        'action=ajaxIssueByTag',
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
    if (!is_null($order))
      $params[] = 'order=' . urlencode($order);
    return '?' . join('&', $params);
  }

  /**
   * @param Smarty $smarty
   * @return void
   */
  private function processAjaxIssueByTagRequest(Smarty $smarty): void {
    $this->listType = 'gropupped-list';
    $this->getAjaxParameters();
    $this->readIssuesAjaxByTag($this->categoryId, $this->typeId, $this->order, $this->page, $this->limit);
    $this->assignAjax($smarty);
  }

  /**
   * @param Smarty $smarty
   * @return void
   */
  private function processAjaxIssueRequest(Smarty $smarty): void {
    $this->getAjaxParameters();
    $path = getOrDefault('path', null);
    $this->listType = is_null($path) ? 'full-list' : 'filtered-list';
    $this->readIssuesAjax($this->categoryId, $this->typeId, $path, $this->order, $this->page, $this->limit);
    $this->assignAjax($smarty);
    $smarty->assign('path', $path);
  }

  /**
   * @param Smarty $smarty
   * @return void
   */
  private function processRecordRequest(Smarty $smarty): void {
    $recordId = getOrDefault('recordId', '');
    if ($recordId != '') {
      $this->getRecordIssues($recordId, $smarty);
    }
  }

  /**
   * @return void
   */
  private function processDownloadOrQueryRequest(): void {
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
  }

  /**
   * @param Smarty $smarty
   * @return void
   * @throws SmartyException
   */
  private function processListRequest(Smarty $smarty): void {
    if ($this->catalogue->getSchemaType() == 'PICA') {
      if (!is_null($this->analysisParameters)) {
        $schemaFile = isset($this->analysisParameters->picaSchemaFile)
          ? $this->analysisParameters->picaSchemaFile
          : 'avram-k10plus-title.json';
        $smarty->assign('schemaFile', $schemaFile);
      }
    }
    $this->readCategories();
    $this->readTypes();
    $this->readIssues();

    $smarty->assign('records', $this->records);
    $smarty->assign('categories', $this->categories);
    $smarty->assign('types', $this->types);
    $smarty->assign('topStatistics', Issues::readTotal(
      $this->filePath('issue-total.csv'),
      $this->count,
      $this->grouped,
      ($this->grouped ? $this->currentGroup : null)));
    $smarty->assign('total', $this->count);
    $smarty->assign('fieldNames', ['path', 'message', 'url', 'instances', 'records']);
    $smarty->assign('listType', 'full-list');
    $smarty->assign('path', null);
    $smarty->assign('order', null);
    $smarty->registerPlugin("function", 'showMarcUrl', array('Issues', 'showMarcUrl'));
  }
}
