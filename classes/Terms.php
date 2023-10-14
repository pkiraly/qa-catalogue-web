<?php

include_once 'Facet.php';
include_once 'Facetable.php';

class Terms extends Facetable {

  private $facet;
  private $action = 'list';
  public $grouped = false;
  public $groupId = false;
  public $groups;
  public $currentGroup;
  public $params;
  /**
   * The field type variant (tokenized or phrase)
   * @var mixed|null
   */
  private $variant;

  public function __construct($configuration, $db) {
    parent::__construct($configuration, $db);
    parent::readAnalysisParameters('validation.params.json');
    $this->grouped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
    if ($this->grouped) {
      $this->groupBy = $this->analysisParameters->groupBy;
      $this->groupId = getOrDefault('groupId', 0);
    }

    $this->facet = getOrDefault('facet', '');
    $this->query = getOrDefault('query', '*:*');
    $this->filters = getOrDefault('filters', []);
    $this->scheme = getOrDefault('scheme', '');
    $this->offset = getOrDefault('offset', 0);
    $this->termFilter = getOrDefault('termFilter', '');
    $this->ajaxFacet = getOrDefault('ajax', 0, [0, 1]);
    $this->facetLimit = getOrDefault('limit', 100, [10, 25, 50, 100]);
    $this->action = getOrDefault('action', 'list', ['list', 'download', 'fields', 'term-count']);
    $this->variant = getOrDefault('variant', 'phrase', ['phrase', 'tokenized']);

    $this->params = [
      'facet' => $this->facet,
      'query' => $this->query,
      'filters' => $this->filters,
      'scheme' => $this->scheme,
      'termFilter' => $this->termFilter,
      'facetLimit' => $this->facetLimit,
      'lang' => $this->lang
    ];
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $smarty->assign('analysisTimestamp', $this->analysisParameters->analysisTimestamp);

    if ($this->grouped && $this->groupId != 0)
      $this->filters[] = $this->getRawGroupQuery();

    if ($this->action == 'download') {
      $this->downloadAction();
    } else if ($this->action == 'term-count') {
      $this->termCountAction();
    } else if ($this->action == 'fields') {
      $this->fieldsAction();
    } else {
      $this->listAction($smarty);
    }
  }

  private function download($facets) {
    $attachment = sprintf('attachment; filename="facet-terms-for-%s-%d-at-%s.csv"', $this->facet, $this->offset, date("Y-m-d"));
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
    return $this->getFacets($this->facet, $this->query, $this->facetLimit, $this->offset, $this->termFilter, $this->filters);
  }

  private function getCount() {
    return $this->countFacets($this->facet, $this->query, $this->termFilter, $this->filters);
  }

  private function createPrevLink() {
    if ($this->offset - $this->facetLimit > 0)
      return $this->createNavLink($this->offset-$this->facetLimit);
    return '';
  }

  public function createDownloadLink() {
    return $this->createNavLink($this->offset) . '&action=download&ajax=1';
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
    $params = [
      'tab=data',
      'query=' . urlencode($this->query)
    ];
    if ($this->filters)
      foreach ($this->filters as $filter)
        $params[] = 'filters[]=' . $filter;

    return $params;
  }

  private function getFields() {
    $fieldNames = $this->getSolrFields();
    sort($fieldNames);
    return $fieldNames;
  }

  public function getCountUrl() {
    $params = ['tab=terms', 'action=term-count'];
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
   * @return void
   */
  private function downloadAction(): void {
    $this->output = 'none';

    $attachment = sprintf('attachment; filename="facet-terms-for-%s-%d-at-%s.csv"', $this->facet, $this->offset, date("Y-m-d"));
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . $attachment);
    $out = fopen('php://output', 'w');
    fputcsv($out, ['term', 'count']);
    $limit = 1000;
    $offset = 0;
    do {
      $facets = $this->getFacets($this->facet, $this->query, $limit, $offset, $this->termFilter, $this->filters);
      $i = 0;
      foreach ($facets as $facet => $values) {
        foreach ($values as $term => $count) {
          fputcsv($out, [$term, $count]);
          $i++;
        }
      }
      $offset += $i;
    } while ($i == $limit);
    fclose($out);
  }

  /**
   * @return void
   */
  private function termCountAction(): void {
    $this->output = 'none';
    echo number_format($this->getCount());
  }

  /**
   * @return void
   */
  private function fieldsAction(): void {
    $term = getOrDefault('term', '');
    $this->output = 'none';
    $fileName = $this->getFieldMapFileName();
    if (file_exists($fileName)) {
      $fileDate = date("Y-m-d H:i:s", filemtime($fileName));
      if ($this->getSolrModificationDate() > $fileDate) {
        unlink($fileName);
      }
    }
    if (!file_exists($fileName)) {
      $allFields = [];
      foreach ($this->getFields() as $field) {
        $label = $this->resolveSolrField($field);
        $allFields[] = ['label' => $label, 'value' => $field];
      }
      file_put_contents($fileName, json_encode($allFields));
    } else {
      $allFields = json_decode(file_get_contents($fileName));
    }
    $fields = [];
    foreach ($allFields as $field) {
      $label = is_object($field) ? $field->label : $field['label'];
      $value = is_object($field) ? $field->value : $field['value'];
      if (
               (
                    $term == ''
                 || strpos(strtoupper($label), strtoupper($term)) !== false
                 || strpos(strtoupper($value), strtoupper($term)) !== false
               )
           &&
               (
                    ($this->variant == 'tokenized' && preg_match('/_txt$/', $value))
                 || ($this->variant == 'phrase'    && preg_match('/_ss$/', $value))
               )
        )
        $fields[] = ['label' => $label, 'value' => $value];
    }
    print json_encode($fields);
  }

  /**
   * @param Smarty $smarty
   * @return void
   */
  private function listAction(Smarty $smarty): void {
    $smarty->assign('grouped', $this->grouped);
    $smarty->assign('currentGroup', $this->currentGroup);

    $smarty->assign('groupId',   $this->groupId);
    $smarty->assign('facet',     $this->facet);
    $smarty->assign('query',     $this->query);
    $smarty->assign('filters',   $this->filters);
    $smarty->assign('scheme',    $this->scheme);

    $smarty->assign('termFilter',$this->termFilter);
    $smarty->assign('facetLimit',$this->facetLimit);
    $smarty->assign('offset',    $this->offset);
    $smarty->assign('ajaxFacet', $this->ajaxFacet);
    $smarty->assign('params',    $this->params);

    $facets = $this->createTermList();
    if ($this->grouped) {
      $this->groups = $this->readGroups();
      $this->currentGroup = $this->selectCurrentGroup();
      if (isset($this->currentGroup->count))
        $this->count = $this->currentGroup->count;
      $smarty->assign('currentGroup', $this->currentGroup);
      $smarty->assign('groups', $this->groups);
    }

    $smarty->assign('facets', $facets);
    $smarty->assign('label', $this->resolveSolrField($this->facet));
    $smarty->assign('basicFacetParams', ['tab=data', 'query=' . $this->query]);
    $smarty->assign('prevLink', $this->createPrevLink());
    if (isset($facets->{$this->facet}))
      $smarty->assign('nextLink', $this->createNextLink(get_object_vars($facets->{$this->facet})));
    else
      $smarty->assign('nextLink', '');

    // if ($this->facet == '' && $this->query == '')
    $smarty->assign('solrFields', $this->getFields());
    error_log('done');
  }
}