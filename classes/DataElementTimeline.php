<?php

/**
 * Timeline of a data element usage.
 */
class DataElementTimeline extends BaseTab {

  protected $parameterFile = 'marctosolr.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $dataElement = getOrDefault('field', '');
    $this->action = getOrDefault('action', 'list', ['list', 'download']);

    $smarty->assign('dataElement', $dataElement);
    $smarty->assign('label', $this->resolveSolrField($dataElement));
    if ($this->action == 'download') {
      $this->downloadAction($dataElement);
    }
  }

  public function getTemplate() {
    return 'data-element-timeline/timeline.tpl';
  }

  private function getYearRange(int $startYear) {
    $endYear = date("Y");
    $range = range($startYear - 1900, $endYear - 1900);
    return array_map(function($a) {return sprintf('%02d', $a >= 100 ? $a - 100 : $a);}, $range);
  }

  /**
   * Download the distribution as CSV file
   *
   * @param $dataElement
   *   The data element (as a Solr field)
   * @return void
   */
  private function downloadAction($dataElement): void {
    $this->output = 'none';
    header('Content-Type: text/csv; charset=utf-8');

    $query = 'q=' . urlencode($dataElement . ':*');
    $facetQueries = [];
    $prefixes = $this->getYearRange(1970);
    foreach ($prefixes as $prefix) {
      $facetQueries[] = 'facet.query=' . urlencode(sprintf("008all00_GeneralInformation_dateEnteredOnFile_ss:%s*", $prefix));
    }
    $result = $this->solr()->getQueryFacets($query, $facetQueries);
    echo "count,frequency\n";
    foreach ($result as $value => $count) {
      $value = (int) preg_replace('/^008all00_GeneralInformation_dateEnteredOnFile_ss:(..)\*$/', '${1}', $value);
      $value = 1900 + ($value >= 70 ? $value : $value + 100);
      echo "$value,$count\n";
    }
  }
}