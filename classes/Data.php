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

  public function __construct($configuration, $db) {
    parent::__construct($configuration, $db);
    $this->facet = getOrDefault('facet', '');
    $this->query = getOrDefault('query', '*:*');
    $this->filters = getOrDefault('filters', []);
    $this->start = getOrDefault('start', 0);
    $this->rows = (int) getOrDefault('rows', 10, $this->itemsPerPageSelectors);

    $this->parameters = [
        'wt=json',
        'json.nl=map',
        'json.wrf=?',
        'facet=on',
        'facet.limit=' . $this->facetLimit
    ];
  }

  public function prepareData(&$smarty) {
    $smarty->assign('db', $this->db);
    $smarty->assign('query', $this->query);
    $smarty->assign('start', $this->start);
    $smarty->assign('rows', $this->rows);
    $smarty->assign('facetLimit', $this->facetLimit);
    $smarty->assign('filters', $this->getFilters());
    $smarty->assign('offset', $this->offset);

    $response = $this->getSolrResponse($this->buildParameters([]));
    $smarty->assign('numFound', $response->numFound);
    $smarty->assign('docs', $response->docs);
    $smarty->assign('facets', $response->facets);
    $smarty->assign('solrUrl', join('&', $this->buildParameters([])));
    $smarty->assign('itemsPerPage', $this->getItemPerPage());
    $smarty->assign('prevNextLinks', $this->createPrevNextLinks($response->numFound));
    $smarty->assign('basicFacetParams', $this->getBasicUrl());
    $smarty->assign('ajaxFacet', $this->ajaxFacet);

    $smarty->assign('controller', $this);
    // $smarty->registerPlugin("function", "getRecord", array('Data', 'getRecord'));

    // $smarty->registerPlugin("function", "getFirstField", array($this, 'getFirstField'));
  }

  public function getTemplate() {
    return 'data.tpl';
  }

  private function getBasicUrl(array $excluded = []) {
    $urlParams = ['tab=data'];
    $baseParams = ['query', 'facet', 'filters', 'start', 'rows'];
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
      'q=' . $this->query,
      'start=' . $this->start,
      'rows=' . $this->rows,
      'core=' . $this->db,
    ];

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
        $items[] = new Link($rows,'');
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
      $solrField = preg_replace('/^([^:]+):"(.*)"$/', "$1", $filter);
      $label = preg_replace('/^[^:]+:"(.*)"/', "$1", $filter);
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

  public function getRecord($doc) {
    $record = new Record($doc, $this->configuration, $this->db);
    $record->setBasicQueryParameters($this->getBasicUrl(['query', 'filters']));
    $record->setBasicFilterParameters($this->getBasicUrl([]));
    return $record;
  }

  function getBasicFacetParams() {
    return $this->getBasicUrl();
  }
}