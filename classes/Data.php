<?php

include_once 'Link.php';
include_once 'Record.php';
include_once 'Facet.php';
include_once 'Facetable.php';

class Data extends Facetable {

  private $facet;
  protected $query;
  private $filters;
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
  public $groupped = false;
  public $groupId = false;
  public $groupBy = false;
  public $params;
  public $action;

  public function __construct($configuration, $db) {
    parent::__construct($configuration, $db);
    parent::readAnalysisParameters('validation.params.json');
    $this->facet = getOrDefault('facet', '');
    $this->query = getOrDefault('query', '*:*');
    $this->filters = getOrDefault('filters', []);
    $this->start = (int) getOrDefault('start', 0);
    $this->rows = (int) getOrDefault('rows', 10, $this->itemsPerPageSelectors);
    $this->type = getOrDefault('type', 'solr', ['solr', 'issues']);
    $this->action = getOrDefault('action', 'search', ['search', 'download']);
    $this->groupped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
    if ($this->groupped)
      $this->groupBy = $this->analysisParameters->groupBy;
    $this->groupId = getOrDefault('groupId', 0);

    $this->params = [
      'facet' => $this->facet,
      'query' => $this->query,
      'filters' => $this->filters,
      'scheme' => $this->scheme,
      'lang' => $this->lang,
      'type' => $this->type,
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
    if ($this->action == 'download') {
      $this->downloadAction();
    } else {
      parent::prepareData($smarty);
      $this->searchAction($smarty);
    }
  }

  public function getTemplate() {
    return 'data/data.tpl';
  }

  private function getBasicUrl(array $excluded = []) {
    $urlParams = ['tab=data'];
    $baseParams = ['query', 'facet', 'filters', 'start', 'rows', 'type', 'groupId'];
    foreach ($baseParams as $p) {
      if (!in_array($p, $excluded))
        if (is_array($this->$p))
          foreach ($this->$p as $value)
            $urlParams[] = $p . '[]=' . urlencode($value);
        else
          $urlParams[] = $p . '=' . urlencode($this->$p);
    }
    return $urlParams;
  }

  private function buildParameters() {
    $solrParams = [
      'rows=' . $this->rows,
      'core=' . $this->db,
    ];

    if ($this->type == 'issues') {
      if (preg_match('/^(categoryId|typeId|errorId):(\d+)$/', $this->query, $matches)) {
        $recordIds = $this->prepareParametersForIssueQueries($matches);
        $query = 'id:("' . join('" OR "', $recordIds) . '")';
        /*
        if ($this->groupped) {
          $query .= sprintf(' AND %s_ss:"%s"', $this->groupBy, $this->groupId);
        }
        */
        $solrParams[] = 'q=' . urlencode($query);
        $solrParams[] = 'start=' . 0;
      }
    } else {
      $solrParams[] = 'q=' . $this->query;
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
    foreach ($this->getSelectedFacets() as $facet)
      $facetParameters[] = 'facet.field=' . $facet;

    if (count($facetParameters) > 0)
      $facetParameters[] = 'facet.mincount=1';

    return $facetParameters;
  }

  private function getItemPerPage() {
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

  private function createPrevNextLinks($numFound) {
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

  private function getFilters() {
    $basicUrl = $this->getBasicUrl(['filters']);
    $changeQueryUrlParams = $this->getBasicUrl(['query', 'facet', 'filters', 'start']);
    $filterLinks = [];
    foreach ($this->filters as $filter) {
      $solrField = preg_replace('/^([^:]+):(\*|"(.*)")$/', "$1", $filter);
      $label = preg_replace('/^[^:]+:(\*|"(.*)")/', "$1", $filter);
      $marcCode = $this->solrToMarcCode($solrField);

      $otherFilters = array_diff($this->filters, [$filter]);
      if (empty($otherFilters)) {
        $link = new Link($label, join('&', $basicUrl));
        $termQuery = $this->query;
      } else {
        $filters = [];
        foreach ($otherFilters as $other)
          $filters[] = 'filters[]=' . urlencode($other);
        $link = Link::create($label, $basicUrl, $filters);
        $termQuery = $this->query . ' AND ' . join(' AND ', $otherFilters);
      }
      $filterLinks[] = (object)[
        'changeQuery' => Link::withQuery('', $changeQueryUrlParams, $filter),
        'removeLink' => $link,
        'marcCode' => $marcCode,
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
        error_log('invalid type: ' . $type);
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
        error_log('invalid type: ' . $category);
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
        error_log('invalid type: ' . $category);
      }
      $this->typeCache006[$category] = $positions;
    }
    return $this->typeCache006[$category];
  }

  public function getRecord($doc) {
    $record = new Record($doc, $this->configuration, $this->db, $this->catalogue);
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
  private function prepareParametersForIssueQueries($matches): array {
    $idType = $matches[1];
    $id = $matches[2];
    include_once 'IssuesDB.php';
    $dir = sprintf('%s/%s', $this->configuration['dir'], $this->getDirName());
    $db = new IssuesDB($dir);

    $groupId = $this->groupped ? $this->groupId : '';
    if ($idType == 'errorId') {
      $this->numFound = $db->getRecordIdsByErrorIdCount($id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getRecordIdsByErrorId($id, $groupId, $this->start, $this->rows);
    } else if ($idType == 'categoryId') {
      /*
      include_once 'Issues.php';
      $issues = new Issues($this->configuration, $this->db);
      $categories = $issues->readIssueCsv('issue-by-category.csv', 'id');
      $this->numFound = $categories[$id]->records; // $db->getRecordIdsByCategoryIdCount($id)->fetchArray(SQLITE3_ASSOC)['count'];
      */
      $this->numFound = $db->getRecordIdsByCategoryIdCount($id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getRecordIdsByCategoryId($id, $groupId, $this->start, $this->rows);
    } else if ($idType == 'typeId') {
      $this->numFound = $db->getRecordIdsByTypeIdCount($id, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
      $result = $db->getRecordIdsByTypeId($id, $groupId, $this->start, $this->rows);
    }

    $recordIds = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $recordIds[] = $row['id'];
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

  /**
   * @param Smarty $smarty
   * @return void
   */
  private function searchAction(Smarty $smarty): void {
    $smarty->assign('query', $this->query);
    $smarty->assign('start', $this->start);
    $smarty->assign('rows', $this->rows);
    $smarty->assign('facetLimit', $this->facetLimit);
    $smarty->assign('filters', $this->getFilters());
    $smarty->assign('offset', $this->offset);
    if ($this->groupped)
      $smarty->assign('groupId', $this->groupId);

    $solrParams = $this->buildParameters();
    $smarty->assign('solrUrl', join('&', $solrParams));
    $response = $this->getSolrResponse($solrParams);
    if (is_null($this->numFound)) {
      $this->numFound = $response->numFound;
    }
    $smarty->assign('numFound', $this->numFound);
    $smarty->assign('docs', $response->docs);
    $smarty->assign('facets', $response->facets);
    $smarty->assign('itemsPerPage', $this->getItemPerPage());
    $smarty->assign('prevNextLinks', $this->createPrevNextLinks($this->numFound));
    $smarty->assign('basicFacetParams', $this->getBasicUrl());
    $smarty->assign('ajaxFacet', $this->ajaxFacet);

    $smarty->assign('schemaType', $this->catalogue->getSchemaType());
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
      $response = $this->getSolrResponse($solrParams);
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
      'core=' . $this->db,
      'fl=id',
    ];

    if ($this->type == 'issues') {
      if (preg_match('/^(categoryId|typeId|errorId):(\d+)$/', $this->query, $matches)) {
        $recordIds = $this->prepareParametersForIssueQueries($matches);
        $query = 'id:("' . join('" OR "', $recordIds) . '")';
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
}