<?php


abstract class Facetable extends BaseTab {

  protected $query;
  protected $offset = 0;
  protected $facetLimit = 100;
  protected $ajaxFacet;
  protected $scheme = '';
  protected $termFilter = '';

  public function createFacet($facetName, $values) {
    return new Facet($facetName, $values, $this);
  }

  public function getQuery() {
    return $this->query;
  }

  public function getOffset() {
    return $this->offset;
  }

  public function getFacetLimit() {
    return $this->facetLimit;
  }

  public function getAjaxFacet() {
    return $this->ajaxFacet;
  }

  public function getScheme() {
    return $this->scheme;
  }

  /**
   * @return string
   */
  public function getTermFilter(): string {
    return $this->termFilter;
  }


  abstract function getBasicFacetParams();
}