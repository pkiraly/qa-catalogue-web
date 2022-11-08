<?php

include_once 'Facet.php';
include_once 'Facetable.php';

class Terms extends Facetable {

  private $facet;
  private $action = 'list';

  public function __construct($configuration, $db) {
    parent::__construct($configuration, $db);
    $this->facet = getOrDefault('facet', '');
    $this->query = getOrDefault('query', '*:*');
    $this->scheme = getOrDefault('scheme', '');
    $this->offset = getOrDefault('offset', 0);
    $this->termFilter = getOrDefault('termFilter', '');
    $this->ajaxFacet = getOrDefault('ajax', 0, [0, 1]);
    $this->facetLimit = getOrDefault('limit', 100, [10, 25, 50, 100]);
    $this->action = getOrDefault('action', 'list', ['list', 'download']);
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('facet',     $this->facet);
    $smarty->assign('query',     $this->query);
    $smarty->assign('scheme',    $this->scheme);

    $smarty->assign('termFilter',$this->termFilter);
    $smarty->assign('facetLimit',$this->facetLimit);
    $smarty->assign('offset',    $this->offset);
    $smarty->assign('ajaxFacet', $this->ajaxFacet);

    $smarty->assign('controller', $this);
    $facets = $this->createTermList();
    if ($this->action == 'download') {
      $this->output = 'none';
      $this->download($facets);
    } else {
      $smarty->assign('facets',    $facets);
      $smarty->assign('label',     $this->resolveSolrField($this->facet));
      $smarty->assign('basicFacetParams', ['tab=data', 'query=' . $this->query]);
      $smarty->assign('prevLink',  $this->createPrevLink());
      if (isset($facets->{$this->facet}))
        $smarty->assign('nextLink',  $this->createNextLink(get_object_vars($facets->{$this->facet})));
      else
        $smarty->assign('nextLink',  '');

      // if ($this->facet == '' && $this->query == '')
      $smarty->assign('solrFields', $this->getFields());
    }
  }

  private function download($facets) {
    $attachment = sprintf('attachment; filename="facet-terms-for-%s-at-%s.csv"', $this->facet, date("Y-m-d"));
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . $attachment);
    echo "term,count\n";
    foreach ($facets as $key => $values) {
      foreach ($values as $term => $count) {
        if (strpos($term, ','))
          $term = sprintf('"%s"', $term);
        echo "$term,$count\n";
      }
    }
  }

  public function getTemplate() {
    return 'terms.tpl';
  }

  public function getAjaxTemplate() {
    return 'marc-facets.tpl';
  }

  private function createTermList() {
    return $this->getFacets($this->facet, $this->query, $this->facetLimit, $this->offset, $this->termFilter);
  }

  private function createPrevLink() {
    if ($this->offset - $this->facetLimit > 0)
      return $this->createNavLink($this->offset-$this->facetLimit);
    return '';
  }

  public function createDownloadLink() {
    return $this->createNavLink($this->offset) . '&action=download';
  }

  private function createNextLink($count) {
    if ($count >= $this->facetLimit)
      return $this->createNavLink($this->offset + $this->facetLimit);
    return '';
  }

  private function createNavLink($offset) {
    $params = [
      'tab=terms',
      'facet=' . $this->facet,
      'query=' . urlencode($this->query),
      'scheme=' . $this->scheme,
      // 'facetLimit=' . $this->facetLimit,
      'offset=' . $offset,
      'termFilter=' . urlencode($this->termFilter),
    ];
    if ($this->ajaxFacet == 1)
      $params[] = 'ajax=1';
    return '?' . join('&', $params);
  }

  public function createFacet($facetName, $values) {
    return new Facet($facetName, $values, $this);
  }

  public function getBasicFacetParams() {
    return [
      'tab=data',
      'query=' . urlencode($this->query)
    ];
  }

  private function getFields() {
    $fieldNames = $this->getSolrFields();
    sort($fieldNames);
    return $fieldNames;
  }
}