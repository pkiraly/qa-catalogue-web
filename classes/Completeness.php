<?php

include_once 'SchemaUtil.php';

class Completeness extends BaseTab {

  private $action = 'list';
  private $hasNonCoreTags = FALSE;
  private $packages = [];
  private $packageIndex = [];
  private $records = [];
  private $types = [];
  protected $type = 'all';
  protected $sort;
  private $max = 0;
  public $groups;
  public $currentGroup;
  private $issueDB;
  private $complexControlFields = ['006', '007', '008'];
  private $types007 = [
    "common" => "Common",
    "map" => "Map",
    "electro" => "Electronic resource",
    "globe" => "Globe",
    "tactile" => "Tactile material",
    "projected" => "Projected graphic",
    "microform" => "Microform",
    "nonprojected" => "Nonprojected graphic",
    "motionPicture" => "Motion picture",
    "kit" => "Kit",
    "music" => "Notated music",
    "remoteSensing" => "Remote-sensing image",
    "soundRecording" => "Sound recording",
    "text" => "Text",
    "video" => "Videorecording",
    "unspecified" => "Unspecified"
  ];
  private $types008 = [
    "all" => "All Materials",
    "book" => "Books",
    "continuing" => "Continuing Resources",
    "music" => "Music",
    "map" => "Maps",
    "visual" => "Visual Materials",
    "computer" => "Computer Files",
    "mixed" => "Mixed Materials"
  ];


  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters('completeness.params.json');
    $this->groupped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
    $smarty->assign('groupped', $this->groupped);
    if ($this->groupped)
      $this->groupBy = $this->analysisParameters->groupBy;

    $this->action = getOrDefault('action', 'list', ['list', 'ajaxGroups']);
    $this->type = getOrDefault('type', 'all', $this->catalogue::$supportedTypes);
    $this->sort = getOrDefault('sort', '', ['number-of-record', 'number-of-instances', 'min', 'max', 'mean', 'stddev']);
    $this->groupId = getOrDefault('groupId', 0);

    if ($this->action == 'list') {
      if ($this->groupped) {
        $this->groups = $this->readGroups();
        $smarty->assign('groups', $this->groups);
        $smarty->assign('groupId', $this->groupId);
        $smarty->assign('params', [
          'type' => $this->type,
          'sort' => $this->sort,
          'lang' => $this->lang
        ]);
        $this->currentGroup = $this->selectCurrentGroup();
        if (isset($this->currentGroup->count))
          $this->count = $this->currentGroup->count;
        $smarty->assign('currentGroup', $this->currentGroup);
        // $smarty->assign('tabSpecificParameters', $this->getTabSpecificParameters());
      }
      $this->readPackages();
      $this->readCompleteness();
      $smarty->assign('packages', $this->packages);
      $smarty->assign('packageIndex', $this->packageIndex);
      if ($this->sort != '') {
        $smarty->assign('records', $this->orderBy());
      } else {
        $smarty->assign('records', $this->records);
      }
      $smarty->assign('types', $this->types);
      $smarty->assign('selectedType', $this->type);
      $smarty->assign('max', $this->max);
      $smarty->assign('hasNonCoreTags', $this->hasNonCoreTags);
      $smarty->assign('sort', $this->sort);
      $smarty->assign('groupFilter', $this->getGroupFilter());
      $smarty->assign('groupQuery', $this->getGroupQuery());

    } else if ($this->action == 'ajaxGroups') {
      $term = getOrDefault('term', '');
      if ($term == '' || $term == ' ')
        $term = 'all';
      $this->output = 'none';
      $groups = $this->readGroups();
      $labels = [];
      foreach ($groups as $group)
        if (($term == 'all' && $group->group == $term) || ($term != 'all' && strpos(strtoupper($group->group), strtoupper($term)) !== false))
          $labels[] = ['label' => $group->group . ' (' . $group->count . ')', 'value' => $group->id];
      print json_encode($labels);
    }
  }

  public function getTemplate() {
    return 'completeness/completeness.tpl';
  }

  public function getAjaxTemplate() {
    return null;
  }

  private function readPackages() {
    $fileName = $this->groupped ? 'completeness-groupped-packages.csv' : 'packages.csv';
    $elementsFile = $this->getFilePath($fileName);

    if (file_exists($elementsFile)) {
      $start = microtime(true);
      // name,label,count
      $lineNumber = 0;
      $header = [];

      // $fieldDefinitions = json_decode(file_get_contents('schemas/marc-schema-with-solr-and-extensions.json'));
      $handle = fopen($elementsFile, "r");
      if ($handle) {
        while (($line = fgets($handle)) !== false) {
          $lineNumber++;
          $values = str_getcsv($line);
          if ($lineNumber == 1) {
            $header = $values;
          } else {
            if (count($header) != count($values)) {
              error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
              error_log($line);
            }
            $record = (object)array_combine($header, $values);

            if (isset($record->documenttype) && $record->documenttype != $this->type)
              continue;

            if ($this->groupped && $record->group != $this->groupId)
              continue;

            $record->packageid = (int)$record->packageid;
            $this->packageIndex[$record->packageid] = $record->iscoretag == 'true'
              ? $record->name . ': ' . $record->label
              : $record->label;

            $this->max = max($this->max, $record->count);
            // $record->percent = $record->count * 100 / $this->count;
            if ($record->label == '') {
              $record->iscoretag = false;
            }
            if (isset($record->iscoretag) && $record->iscoretag === "true") {
              $record->iscoretag = true;
            } else {
              $this->hasNonCoreTags = TRUE;
              $record->iscoretag = false;
            }
            $this->packages[] = $record;
          }
        }
      }
      $t1 = microtime(true) - $start;

      foreach ($this->packages as $package)
        $package->percent = $package->count * 100 / $this->max;

      $tforeach = microtime(true) - $start;
      usort($this->packages, function($a, $b){
        return ($a->packageid == $b->packageid)
          ? 0
          : (($a->packageid < $b->packageid)
            ? -1
            : 1);
      });
      $tusort = microtime(true) - $start;
      error_log(sprintf('readPackages) read file: %.4f, foreach: %.4f, usort: %.4f', $t1, $tforeach, $tusort));
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
  }

  private function hasGrouppedMarcElementTable() {
    include_once 'IssuesDB.php';
    $this->issueDB = new IssuesDB($this->getDbDir());
    if ($this->groupped) {
      return $this->issueDB->hasGrouppedMarcElementTable()->fetchArray(SQLITE3_ASSOC)['count'] == 1;
    }
    return false;
  }

  private function readCompleteness() {
    SchemaUtil::initializeSchema($this->catalogue->getSchemaType());
    error_log('hasGrouppedMarcElementTable: ' . (int)$this->hasGrouppedMarcElementTable());
    if ($this->groupped && $this->hasGrouppedMarcElementTable()) {

      $start = microtime(true);
      $result = $this->issueDB->getGrouppedMarcElements($this->groupId, $this->type);
      while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $this->processRecord((object)$row);
      }
      $tread = microtime(true) - $start;
      ksort($this->records, SORT_NUMERIC);
      $tsort = microtime(true) - $start;
      $this->types = array_merge(['all'], array_diff($this->types, ['all']));
      $tmerge = microtime(true) - $start;
      error_log(sprintf('readCompleteness) read: %.4f, sort: %.4f, merge: %.4f', $tread, $tsort, $tmerge));

    } else {
      $fileName = $this->groupped ? 'completeness-groupped-marc-elements.csv' : 'marc-elements.csv';
      $elementsFile = $this->getFilePath($fileName);
      if (file_exists($elementsFile)) {
        $start = microtime(true);
        // $keys = ['element','number-of-record',number-of-instances,min,max,mean,stddev,histogram]; // "sum",
        $lineNumber = 0;
        $header = [];

        $fieldDefinitions = json_decode(file_get_contents('schemas/marc-schema-with-solr-and-extensions.json'));
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
              $record = (object)array_combine($header, $values);

              if (isset($record->documenttype) && $record->documenttype != $this->type)
                continue;

              if ($this->groupped && $record->groupId != $this->groupId)
                continue;

              $this->processRecord($record);
            }
          }
          $tread = microtime(true) - $start;
        }

        ksort($this->records, SORT_NUMERIC);
        $tsort = microtime(true) - $start;
        $this->types = array_merge(['all'], array_diff($this->types, ['all']));
        $tmerge = microtime(true) - $start;
        error_log(sprintf('readCompleteness) read: %.4f, sort: %.4f, merge: %.4f', $tread, $tsort, $tmerge));
      } else {
        $msg = sprintf("file %s is not existing", $elementsFile);
        error_log($msg);
      }
    }
  }

  private function searchFieldLink($field) {
    return sprintf('?tab=data&query=*:*&filters[]=%s:*', $field);
  }

  private function orderBy() {
    $records = [];
    foreach ($this->records as $packageId => $package) {
      foreach ($package as $tag => $_records) {
        foreach ($_records as $record) {
          $records[] = $record;
        }
      }
    }
    usort($records, function ($item1, $item2) {
      return [$item2->{$this->sort}, $item1->path] <=> [$item1->{$this->sort}, $item2->path];
    });
    return $records;
  }

  private function getGroupFilter() {
    static $groupFilter;
    if (!isset($groupFilter)) {
      if ($this->groupped && $this->groupId != 0)
        $groupFilter = sprintf('filters[]=%s:%s',
          $this->picaToSolr(str_replace('$', '', $this->groupBy)) . '_ss',
          urlencode(sprintf('"%s"', $this->groupId)));
      else
        $groupFilter = '';
    }
    return $groupFilter;
  }

  private function getGroupQuery() {
    if ($this->groupped && $this->groupId != 0) {
      $query = urlencode(' AND ') . sprintf('%s:%s',
        $this->picaToSolr(str_replace('$', '', $this->groupBy)) . '_ss',
        urlencode(sprintf('"%s"', $this->groupId)));
      return $query;
    }
    return '';
  }

  private function safe($input) {
    return preg_replace_callback('/([^a-zA-Z0-9])/', function ($matches) { return 'x' . dechex(ord($matches[1])); }, $input);
  }

  public function getTabSpecificParameters($key, $value) : string {
    $params = [];
    $params[] = sprintf('%s=%s', $key, $value);
    $params = array_merge($params, $this->getGeneralParams());
    $this->addParam($params, $this, 'type', 'all', [$key]);
    $this->addParam($params, $this, 'sort', '', [$key]);
    $this->addParam($params, $this, 'groupId', 0, [$key]);
    if (!empty($params))
      return '&' . join('&', $params);
    return '';
  }

  public function queryLink($record) : string {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=data',
        'query=' . ($this->type == 'all' ? '*:*' : 'type_ss:' . urlencode(sprintf('"%s"', $this->type))),
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if ($this->getGroupFilter() != '')
        $baseParams[] = $this->getGroupFilter();
    }
    $params = $baseParams;
    $params[] = 'filters[]=' . $record->solr . ':*';
    return '?' . join('&', $params);
  }

  public function termsLink($record) : string {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=terms',
        'query=' . ($this->type == 'all' ? '*:*' : 'type_ss:' . urlencode(sprintf('"%s"', $this->type))),
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if ($this->groupped && $this->groupId != 0)
        $baseParams[] = 'groupId=' . $this->groupId;
    }
    $params = $baseParams;
    $params[] = 'facet=' . $record->solr;
    return '?' . join('&', $params);
  }

  /**
   * @param object $record
   * @param array $matches
   * @return array
   */
  private function processRecord(object $record): void {
    if (!in_array($record->documenttype, $this->types))
      $this->types[] = $record->documenttype;

    // $this->max = max($this->max, $record->{'number-of-record'});
    $record->{'number-of-record'} = $record->{'number-of-record'} == '' ? 0 : $record->{'number-of-record'};
    $record->mean = sprintf('%.2f', $record->mean);
    $record->stddev = sprintf('%.2f', $record->stddev);
    $record->percent = $record->{'number-of-record'} * 100 / $this->max;

    $histogram = new stdClass();
    if ($record->histogram != '') {
      foreach (explode('; ', $record->histogram) as $entry) {
        list($k, $v) = explode('=', $entry);
        $histogram->$k = $v;
      }
    }
    $record->histogram = $histogram;
    $record->solr = $this->getSolrField($record->path);

    if ($this->catalogue->getSchemaType() == 'MARC21' && preg_match('/^(leader|00.)(.+)$/', $record->path, $matches)) {
      $tag = $matches[1];
      $record->isField = false;
    } else {
      $parts = explode('$', $record->path, 2);
      $record->isField = count($parts) == 1;
      $tag = $parts[0];
      if (!$record->isField)
        $this->subfieldCode = $parts[1];
    }
    $record->extractedTag = $tag;
    $record->websafeTag = $this->safe($tag);
    $definition = SchemaUtil::getDefinition($tag);

    $record->isLeader = false;
    $record->isComplexControlField = in_array($tag, $this->complexControlFields);

    if ($record->isComplexControlField) {
      if (preg_match('/^...([a-zA-Z]+)(\d+)$/', $record->path, $matches)) {
        $record->complexType = $matches[1];
        $record->complexPosition = $matches[2];
        if ($tag == '007')
          $record->complexType = $this->types007[$record->complexType];
        else
          $record->complexType = $this->types008[$record->complexType];
      }
    } elseif (preg_match('/^leader(..)$/', $record->path, $matches)) {
      $record->isLeader = true;
      $record->complexPosition = $matches[1];
    }

    if ($record->package == '')
      $record->package = 'other';

    $pica3 = ($definition != null && isset($definition->pica3) ? '=' . $definition->pica3 : '');
    if ($record->tag == '') {
      // $record->tag = substr($record->path, 0, $position);
      $record->tag = $tag . $pica3;
    } elseif (!$record->isLeader) {
      // $record->tag = substr($record->path, 0, $position) . ' &mdash; ' . $record->tag;
      $record->tag = $tag . $pica3 . ' &mdash; ' . $record->tag;
    }

    $record->packageid = (int)$record->packageid;
    if (!isset($this->records[$record->packageid]))
      $this->records[$record->packageid] = [];

    if (!isset($this->records[$record->packageid][$record->tag])) {
      if ($record->tag == 'Leader') {
        $this->records[$record->packageid] = array_merge([$record->tag => []], $this->records[$record->packageid]);
      } else {
        $this->records[$record->packageid][$record->tag] = [];
      }
    }

    $this->records[$record->packageid][$record->tag][] = $record;
  }
}
