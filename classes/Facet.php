<?php


class Facet {

  private $facetName;
  private $values;

  private $controller;
  private $count;

  /**
   * TemList constructor.
   * @param $facetName
   * @param $values
   */
  public function __construct($facetName, $values, $controller) {
    $this->facetName = $facetName;
    $this->values = $values;
    $this->controller = $controller;
    $this->count = count(get_object_vars($this->values));
  }

  public function createLink($term) {
    return '?' . join('&', $this->controller->getBasicFacetParams()) . sprintf('&filters[]=%s:%%22%s%%22', $this->facetName, urlencode($term));
  }

  public function hasPrevList() {
    return ($this->controller->getOffset() - $this->controller->getFacetLimit() >= 0);
  }

  public function createPrevLink() {
    if ($this->hasPrevList())
      return $this->createNavLink($this->controller->getOffset() - $this->controller->getFacetLimit());
    return '';
  }

  public function hasNextList() {
    return ($this->count >= $this->controller->getFacetLimit());
  }

  public function createNextLink() {
    if ($this->hasNextList())
      return $this->createNavLink($this->controller->getOffset() + $this->controller->getFacetLimit());
    return '';
  }

  private function createNavLink($offset) {
    $params = [
      'tab=terms',
      'facet=' . $this->facetName,
      'query=' . urlencode($this->controller->getQuery()),
      'scheme=' . urlencode($this->controller->getScheme()),
      'limit=' . $this->controller->getFacetLimit(),
      'offset=' . $offset,
      'termFilter=' . urlencode($this->controller->getTermFilter()),
    ];
    $filters = $this->controller->getFilters();
    if (!is_null($filters))
      foreach ($filters as $filter)
        $params[] = 'filters[]=' . urlencode($filter);

    if ($this->controller->getAjaxFacet() == 1)
      $params[] = 'ajax=1';
    return '?' . join('&', $params);
  }

}