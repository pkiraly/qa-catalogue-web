<?php

class Data extends Facetable {

  private $facet;
  protected $query;
  private $start;
  private $rows;
  private $itemsPerPageSelectors = [10, 25, 50, 100];
  private $parameters;
  protected $facetLimit = 10;
  protected $ajaxFacet = 1;
  private $typeCache008 = [];
  private $typeCache007 = [];
  private $typeCache006 = [];
  private $type = 'solr';
  private $numFound = null;
  public bool $grouped = false;
  public $groupId = false;
  public string $groupBy;
  public $params;
  public string $action;
  private $searchform = 'simple';
  protected $parameterFile = 'marctosolr.params.json';
  private ?array $allGroups;

  public function __construct($configuration, $id) {
    parent::__construct($configuration, $id);
    $this->facet = getOrDefault('facet', '');
    $this->query = getOrDefault('query', '*:*');
    $this->filters = getOrDefault('filters', []);
    $this->start = (int) getOrDefault('start', 0);
    $this->rows = (int) getOrDefault('rows', 10, $this->itemsPerPageSelectors);
    $this->type = getOrDefault('type', 'solr', ['solr', 'issues', 'custom-rule', 'translations']);
    $this->action = getOrDefault('action', 'search', ['search', 'download']);
    $this->groupId = getOrDefault('groupId', 0);
    $this->searchform = getOrDefault('searchform', 'simple', ['simple', 'advanced']);
    if ($this->searchform == 'advanced') {
      for ($i = 1; $i <= 3; $i++) {
        $field = 'field' . $i;
        $value = 'value' . $i;
        $this->{$field} = getOrDefault($field, '');
        $this->{$value} = getOrDefault($value, '');
      }
    }

    $this->params = [
      'facet' => $this->facet,
      'query' => $this->query,
      'filters' => $this->filters,
      'scheme' => $this->scheme,
      'lang' => $this->lang,
      'type' => $this->type,
      'searchform' => $this->searchform,
    ];

    $this->parameters = [
      'wt=json',
      'q.op=AND',
      'json.nl=map',
      'json.wrf=?',
      'facet=on',
      'facet.limit=' . $this->facetLimit
    ];
  }

  public function prepareData(Smarty &$smarty) {
    try {
      if ($this->action == 'download') {
        $this->downloadAction();
      } else {
        $this->log->info('call parent::prepareData');
        parent::prepareData($smarty);
        $this->grouped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
        if ($this->grouped)
          $this->groupBy = $this->analysisParameters->groupBy;
        if (isset($this->analysisParameters->analysisTimestamp))
          $smarty->assign('analysisTimestamp', $this->analysisParameters->analysisTimestamp);
        $this->searchAction($smarty);
     }
    } catch(Exception $e) {
      $smarty->assign('error', $e->getMessage());
    }
  }

  public function getTemplate() {
    return 'data/data.tpl';
  }

  /**
   * Get the page parameters
   * @param array $excluded The keys to exclude
   * @return string[]
   */
  private function getBasicUrl(array $excluded = []): array {
    $urlParams = ['tab=data'];
    $baseParams = ['query', 'facet', 'filters', 'start', 'rows', 'type', 'searchform'];
    if ($this->searchform == 'advanced')
      $baseParams = array_merge($baseParams, ['field1', 'value1', 'field2', 'value2', 'field3', 'value3']);
    if ($this->grouped)
      $baseParams = array_merge($baseParams, ['groupId']);
    foreach ($baseParams as $property) {
      if (!in_array($property, $excluded))
        if (is_array($this->{$property})) // FIXME: fields are not defined in this class
          foreach ($this->{$property} as $value)
            $urlParams[] = $property . '[]=' . urlencode($value);
        else
          $urlParams[] = $property . '=' . urlencode($this->{$property});
    }
    return $urlParams;
  }

  private function buildParameters(Smarty $smarty): array {
    $solrParams = [
      'rows=' . $this->rows,
      'core=' . $this->id,
    ];

    if ($this->type == 'issues') {
      if (preg_match('/^(categoryId|typeId|errorId):(\d+)$/', $this->query, $matches)) {
        if ($this->isGroupAndErrorIdIndexed()) {
          $query = $this->getQueryForMainCore($matches);
          $solrParams[] = 'start=' . $this->start;
        } else {
          $recordIds = $this->prepareParametersForIssueQueries($matches[1], $matches[2]);
          $query = 'id:("' . join('" OR "', $recordIds) . '")';
          $solrParams[] = 'start=' . 0;
        }
        $solrParams[] = 'q=' . urlencode($query);
      }
    } else if ($this->type == 'custom-rule' || $this->type == 'translations') {
      if (preg_match('/^([^ ]+):(0|1|NA)$/', $this->query, $matches)) {
        $recordIds = $this->prepareParametersForIssueQueries($matches[1], $matches[2]);
        $query = 'id:("' . join('" OR "', $recordIds) . '")';
        $solrParams[] = 'start=' . 0;
        $solrParams[] = 'q=' . urlencode($query);
      }
    } else {
      if ($this->searchform == 'simple') {
        $solrParams[] = 'q=' . $this->query;
        if ($this->groupId !== 0)
          $solrParams[] = 'fq=' . 'groupId_is:' . $this->groupId;
      } else if ($this->searchform == 'advanced') {
        $fields = [];
        for ($i = 1; $i <= 3; $i++) {
          $field = getOrDefault('field' . $i, '');
          $value = getOrDefault('value' . $i, '');
          $smarty->assign('field' . $i, $field);
          $smarty->assign('value' . $i, $value);
          $smarty->assign('label' . $i, $this->resolveSolrField($field));
          if ($field != '' && $value != '') {
            $fields[] = sprintf('%s:(%s)', $field, $value);
          }
        }
        $solrParams[] = 'q=' . join(' AND ', $fields);
      }
      $solrParams[] = 'start=' . $this->start;
    }

    $solrParams = array_merge($solrParams, $this->parameters);
    $solrParams = array_merge($solrParams, $this->buildFacetParameters());

    if (count($this->filters) > 0)
      foreach ($this->filters as $filter)
        $solrParams[] = 'fq=' . $filter;

    return $solrParams;
  }

  private function buildFacetParameters() {
    $facetParameters = [];
    $selectedFacets = $this->getSelectedFacets();
    if (!is_null($selectedFacets))
      foreach ($selectedFacets as $facet)
        $facetParameters[] = 'facet.field=' . $facet;

    if (count($facetParameters) > 0)
      $facetParameters[] = 'facet.mincount=1';

    return $facetParameters;
  }

  private function getItemPerPage(): array {
    $items = [];
    $baseParams = $this->getBasicUrl(['start', 'rows']);
    foreach ($this->itemsPerPageSelectors as $rows) {
      if ($rows === $this->rows)
        $items[] = new Link($rows, '');
      else
        $items[] = Link::withRows($rows, $baseParams, $rows);
    }
    return $items;
  }

  private function createPrevNextLinks($numFound): array {
    $items = [];
    if ($numFound > 0) {
      $baseParams = $this->getBasicUrl(['start']);
      if ($this->start > 0) {
        for ($i = 1; $i <= 3; $i++) {
          $start = $this->start - ($i * $this->rows);
          if ($start >= 0) {
            $link = Link::withStart($this->getInterval($start, $numFound, false), $baseParams, $start);
            array_unshift($items, $link);
          }
        }
      }
      $items[] = new Link($this->getInterval($this->start, $numFound, true), '');
      for ($i = 1; $i <= 3; $i++) {
        $start = $this->start + ($i * $this->rows);
        if ($start + 1 < $numFound)
          $items[] = Link::withStart($this->getInterval($start, $numFound, false), $baseParams, $start);
      }
    }
    return $items;
  }

  private function getInterval($number, $max, $both) {
    $beginning = $number + 1;
    $startEnd = $beginning . '-';
    if ($both === true) {
      $ending = $number + $this->rows;
      if ($ending > $max)
        $ending = $max;

      if ($ending > $beginning)
        $startEnd .= $ending;
      else
        $startEnd = $beginning;
    }
    return $startEnd;
  }

  private function createFilters() {
    $basicUrl = $this->getBasicUrl(['filters']);
    $changeQueryUrlParams = $this->getBasicUrl(['query', 'facet', 'filters', 'start']);
    $filterLinks = [];
    foreach ($this->filters as $filter) {
      $is_negated = preg_match('/^NOT /', $filter);
      $solrField = preg_replace('/^(?:NOT )?([^:]+):(\*|"(.*)")$/', "$1", $filter);
      $label = preg_replace('/^[^:]+:(\*|"(.*)")/', "$1", $filter);
      $marcCode = $this->solrToMarcCode($solrField);
      $negateFilter = $is_negated
        ? preg_replace('/^NOT /', '', $filter)
        : 'NOT ' . $filter;
      $negation = $is_negated ? 'not' : '';

      $otherFilters = array_diff($this->filters, [$filter]);
      if (empty($otherFilters)) {
        $removeLink = new Link($label, join('&', $basicUrl));
        $basicUrl[] = 'filters[]=' . urlencode($negateFilter);
        $negateLink = new Link($label, join('&', $basicUrl));
        $termQuery = $this->query;
      } else {
        $filters = [];
        $filtersWithNegate = ['filters[]=' . urlencode($negateFilter)];
        foreach ($otherFilters as $other) {
          $filters[] = 'filters[]=' . urlencode($other);
          $filtersWithNegate[] = 'filters[]=' . urlencode($other);
        }
        $removeLink = Link::create($label, $basicUrl, $filters);
        $negateLink = Link::create($label, $basicUrl, $filtersWithNegate);
        $termQuery = $this->query . ' AND ' . join(' AND ', $otherFilters);
      }
      $filterLinks[] = (object)[
        'changeQuery' => Link::withQuery('', $changeQueryUrlParams, $filter),
        'removeLink' => $removeLink,
        'negateLink' => $negateLink,
        'marcCode' => $marcCode,
        'negation' => $negation,
        'termsLink' => sprintf('tab=terms&facet=%s&query=%s', $solrField, urlencode($termQuery))
      ];
    }
    return $filterLinks;
  }

  public function get008Definition($type) {
    if (!isset($this->typeCache008[$type])) {
      $positions = [];
      $tag008 = $this->getFieldDefinitions()->fields->{'008'};
      foreach ($tag008->types->{'All Materials'}->positions as $id => $data) {
        $data->type = 1;
        $positions["" . $id] = $data;
      }
      if (isset($tag008->types->{$type})) {
        foreach ($tag008->types->{$type}->positions as $id => $data) {
          $data->type = 2;
          $positions["" . $id] = $data;
        }
        ksort($positions);
      } else {
        $this->log->error('invalid type: ' . $type);
      }
      $this->typeCache008[$type] = $positions;
    }
    return $this->typeCache008[$type];
  }

  public function get007Definition($category) {
    if (!isset($this->typeCache007[$category])) {
      $positions = [];
      $definition = $this->getFieldDefinitions()->fields->{'007'};
      if (isset($definition->types->{$category})) {
        foreach ($definition->types->{$category}->positions as $id => $data) {
          $positions["" . $id] = $data;
        }
      } else {
        $this->log->error('invalid type: ' . $category);
      }
      $this->typeCache007[$category] = $positions;
    }
    return $this->typeCache007[$category];
  }

  public function get006Definition($category) {
    if (!isset($this->typeCache006[$category])) {
      $positions = [];
      $definition = $this->getFieldDefinitions()->fields->{'006'};
      foreach ($definition->types->{'All Materials'}->positions as $id => $data) {
        $positions["" . $id] = $data;
      }
      if (isset($definition->types->{$category})) {
        foreach ($definition->types->{$category}->positions as $id => $data) {
          $positions["" . $id] = $data;
        }
      } else {
        $this->log->error('invalid type: ' . $category);
      }
      $this->typeCache006[$category] = $positions;
    }
    return $this->typeCache006[$category];
  }

  public function getRecord($doc) {
    $record = new Record($doc, $this->configuration, $this->catalogue, $this->log);
    $record->setBasicQueryParameters($this->getBasicUrl(['query', 'filters']));
    $record->setBasicFilterParameters($this->getBasicUrl([]));
    return $record;
  }

  function getBasicFacetParams() {
    return $this->getBasicUrl();
  }

  /**
   * @param $matches
   * @return array
   */
  private function prepareParametersForIssueQueries($idType, $id): array {
    $this->log->warning("prepareParametersForIssueQueries()");
    $groupId = $this->grouped ? $this->groupId : '';
    $coreToUse = ($this->type == 'custom-rule' || $this->type == 'translations')
               ? ''
               : ($this->isGroupAndErrorIdIndexed() ? $this->configuration->getIndexName() : $this->findCoreToUse());
    if ($coreToUse != '') {
      $recordIds = $this->prepareParametersForIssueQueriesSolr($idType, $id, $groupId, $coreToUse);
    } else {
      $recordIds = $this->prepareParametersForIssueQueriesSqlite($idType, $id, $groupId);
    }
    return $recordIds;
  }

  public function getDownloadLink() {
    $params = ['tab=data', 'action=download'];
    foreach ($this->params as $k => $v) {
      if (is_array($v)) {
        foreach ($v as $value)
          $params[] = sprintf("%s[]=%s", $k, urlencode($value));
      } else {
        $params[] = sprintf("%s=%s", $k, urlencode($v));
      }
    }
    return '?' . join('&', $params);
  }

  private function searchAction(Smarty $smarty): void {
    $smarty->assign('showAdvancedSearchForm', $this->configuration->doShowAdvancedSearchForm());
    $smarty->assign('query', $this->query);
    $smarty->assign('start', $this->start);
    $smarty->assign('rows', $this->rows);
    $smarty->assign('facetLimit', $this->facetLimit);
    $smarty->assign('filters', $this->createFilters());
    $smarty->assign('offset', $this->offset);
    $smarty->assign('grouped', $this->grouped);
    if ($this->grouped) {
      $smarty->assign('groupId', $this->groupId);
      $smarty->assign('groupBy', $this->parseGroupBy($this->groupBy));
    }
    $smarty->assign('itemsPerPage', $this->getItemPerPage());
    $smarty->assign('basicFacetParams', $this->getBasicUrl());
    $smarty->assign('ajaxFacet', $this->ajaxFacet);

    $smarty->assign('schemaType', $this->catalogue->getSchemaType());
    $smarty->assign('searchform', $this->searchform);

    if ($this->configuration->doShowAdvancedSearchForm() && $this->searchform != 'advanced') {
      for ($i = 1; $i <= 3; $i++) {
        $smarty->assign('field' . $i, '');
        $smarty->assign('value' . $i, '');
        $smarty->assign('label' . $i, '');
      }
    }

    // The following may throw an exception when solr is not reachable
    $solrParams = $this->buildParameters($smarty);
    $smarty->assign('solrUrl', join('&', $solrParams));
    $response = $this->solr()->getSolrResponse($solrParams);
    if (is_null($this->numFound)) {
      $this->numFound = $response->numFound;
    }
    $smarty->assign('numFound', $this->numFound);
    $smarty->assign('prevNextLinks', $this->createPrevNextLinks($this->numFound));
    $smarty->assign('docs', $response->docs);
    $smarty->assign('facets', $response->facets);
  }

  /**
   * Create a list of identifiers of the found records, and make it downloadable
   * @return void
   */
  private function downloadAction(): void {
    $this->output = 'none';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . sprintf('attachment; filename="%s"', 'identifiers.csv'));
    $total = 0;
    $start = 0;
    $rows = 1000;
    do {
      $solrParams = $this->buildParametersForDownload($start, $rows);
      $response = $this->solr()->getSolrResponse($solrParams);
      foreach ($response->docs as $doc) {
        echo $doc->id, "\n";
        $total++;
      }
      $start += $rows;
    } while($total < $response->numFound);
  }

  private function buildParametersForDownload($start = 0, $rows = 1000) {
    $solrParams = [
      'start=' . $start,
      'rows=' . $rows,
      'core=' . $this->id,
      'fl=id',
    ];

    if ($this->type == 'issues') {
      if (preg_match('/^(categoryId|typeId|errorId):(\d+)$/', $this->query, $matches)) {
        if ($this->isGroupAndErrorIdIndexed()) {
          $query = $this->getQueryForMainCore($matches);
        } else {
          $recordIds = $this->prepareParametersForIssueQueries($matches[1], $matches[2]);
          $query = 'id:("' . join('" OR "', $recordIds) . '")';
        }
        $solrParams[] = 'q=' . urlencode($query);
      }
    } else {
      $solrParams[] = 'q=' . $this->query;
    }

    $solrParams = array_merge($solrParams, $this->parameters);
    if (count($this->filters) > 0)
      foreach ($this->filters as $filter)
        $solrParams[] = 'fq=' . $filter;

    return $solrParams;
  }

  private function getRecordIdByErrorId($core, $errorId, $groupId = null, $start = 0, $rows = 10): array {
    $query = 'errorId_is:' . $errorId;
    if ($this->grouped && !is_null($groupId))
      $query .= ' AND groupId_is:' . $groupId;

    $response = $this->solr()->getSolrResponse(['q' => $query, 'fl' => 'id', 'start' => $start, 'rows' => $rows]);
    $this->numFound = $response->numFound;
    $recordIds = [];
    foreach ($response->docs as $doc) {
      $recordIds[] = $doc->id;
    }
    return $recordIds;
  }

  private function findCoreToUse(): string {
    $coreToUse = '';
    $cores = ['validation', $this->configuration->getIndexName() . '_validation'];
    foreach ($cores as $core) {
      if ($this->solr()->isCoreAvailable($core)) {
        $coreToUse = $core;
        break;
      }
    }
    return $coreToUse;
  }

  /**
   * @param string $idType The type of identifier (errorId, categoryId, typeId)
   * @param $id The identifier
   * @param $groupId The group identifyer
   * @param string $coreToUse The Solr core to use
   */
  private function prepareParametersForIssueQueriesSolr(string $idType, $id, $groupId, string $coreToUse): ?array {
    if ($idType == 'errorId') {
      return $this->getRecordIdByErrorId($coreToUse, $id, $groupId, $this->start, $this->rows);
    } else if ($idType == 'categoryId') {
      // FIXME: $db is not defined
      $errorIds = $this->issueDB()->fetchAll($db->getErrorIdsByCategoryId($id, $groupId), 'id');
      $this->log->info("errorIds: " . join(', ', $errorIds));
      return $this->getRecordIdByErrorId($coreToUse, '(' . join(' OR ', $errorIds) . ')', $groupId, $this->start, $this->rows);
    } else if ($idType == 'typeId') {
      // FIXME: $db is not defined
      $errorIds = $this->issueDB()->fetchAll($db->getErrorIdsByTypeId($id, $groupId), 'id');
      return $this->getRecordIdByErrorId($coreToUse, '(' . join(' OR ', $errorIds) . ')', $groupId, $this->start, $this->rows);
    }
    return null;
  }

  /**
   * @param string $idType The type of identifier (errorId, categoryId, typeId)
   * @param $id The identifier
   * @param $groupId The group identifyer
   */
  private function prepareParametersForIssueQueriesSqlite(string $idType, $id, $groupId): array {
    if ($idType == 'errorId') {
      $start = microtime(true);
      $this->numFound = $this->issueDB()->getRecordIdsByErrorIdCount($id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $t_count = microtime(true) - $start;
      $result = $this->issueDB()->getRecordIdsByErrorId($id, $groupId, $this->start, $this->rows);
      $t_retrieve = microtime(true) - $start;
      $this->log->warning(sprintf("count: %.2f, retrieve: %.2f", $t_count, $t_retrieve));
    } else if ($idType == 'categoryId') {
      $this->numFound = $this->issueDB()->getRecordIdsByCategoryIdCount($id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $this->issueDB()->getRecordIdsByCategoryId($id, $groupId, $this->start, $this->rows);
    } else if ($idType == 'typeId') {
      $this->numFound = $this->issueDB()->getRecordIdsByTypeIdCount($id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $this->issueDB()->getRecordIdsByTypeId($id, $groupId, $this->start, $this->rows);
    } else if ($this->type == 'custom-rule') {
      if ($this->issueDB()->hasColumnInTable($idType, 'shacl')) {
        $this->numFound = $this->issueDB()->getRecordIdsByShaclCount($idType, $id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
        $result = $this->issueDB()->getRecordIdsByShacl($idType, $id, $groupId, $this->start, $this->rows);
      }
    } else if ($this->type == 'translations') {
      if ($this->issueDB()->hasColumnInTable($idType, 'translations')) {
        $this->numFound = $this->issueDB()->getRecordIdsByTranslationsCount($idType, $id, $groupId)
          ->fetchArray(SQLITE3_ASSOC)['count'];
        $result = $this->issueDB()->getRecordIdsByTranslations($idType, $id, $groupId, $this->start, $this->rows);
      }
    } // FIXME: else? better make idtype an Enum?
    return $this->issueDB()->fetchAll($result, 'id');
  }

  private function isGroupAndErrorIdIndexed() {
    return !is_null($this->indexingParameters)
           && isset($this->indexingParameters->validationUrl)
           && in_array('errorId_is', $this->solr()->getSolrFields());
  }

  /**
   * @param array $matches
   * @return string
   */
  private function getQueryForMainCore(array $matches): string {
    $idType = $matches[1];
    $id = $matches[2];
    if ($idType == 'errorId') {
      $errorId = $id;
    } else {
      if ($idType == 'categoryId') {
        $errorIds = $this->issueDB()->fetchAll($this->issueDB()->getErrorIdsByCategoryId($id, $this->groupId), 'id');
        $errorId = '(' . join(' OR ', $errorIds) . ')';
      } else if ($idType == 'typeId') {
        $errorIds = $this->issueDB()->fetchAll($this->issueDB()->getErrorIdsByTypeId($id, $this->groupId), 'id');
        $errorId = '(' . join(' OR ', $errorIds) . ')';
      }
    }
    $query = 'errorId_is:' . $errorId;
    if ($this->grouped)
      $query .= ' AND groupId_is:' . $this->groupId;
    return $query;
  }

  private function parseGroupBy($groupBy) {
    $parts = explode('$', $groupBy);
    return (object)[
      'full' => $groupBy,
      'tag' => $parts[0],
      'subfield' => $parts[1]
    ];
  }

  public function getLibraryById($id) {
    if (!isset($this->allGroups)) {
      $this->allGroups = [];
      foreach ($this->readGroups() as $group)
        $this->allGroups[$group->id] = $group->group;
    }
    return $this->allGroups[$id] ?? $id;
  }
}
