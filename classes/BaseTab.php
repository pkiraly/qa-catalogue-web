<?php

include_once 'catalogue/Catalogue.php';

abstract class BaseTab implements Tab {

  protected $configuration;
  protected $db;
  protected $count = 0;
  protected static $marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
  protected $solrFields;
  protected $fieldDefinitions;
  protected $catalogueName;
  protected $catalogue;
  protected $lastUpdate;

  /**
   * BaseTab constructor.
   * @param $configuration
   * @param $db
   */
  public function __construct($configuration, $db) {
    $this->configuration = $configuration;
    $this->db = $db;
    $this->catalogueName = isset($configuration['catalogue']) ? $configuration['catalogue'] : $db;
    $this->catalogue = $this->createCatalogue();
    $this->readCount();
    $this->readLastUpdate();
  }

  public function prepareData(Smarty &$smarty) {
    $smarty->assign('db', $this->db);
    $smarty->assign('catalogueName', $this->catalogueName);
    $smarty->assign('catalogue', $this->catalogue);
    $smarty->assign('count', $this->count);
    $smarty->assign('lastUpdate', $this->lastUpdate);
  }

  private function createCatalogue() {
    $className = strtoupper(substr($this->catalogueName, 0, 1)) . substr($this->catalogueName, 1);
    include_once 'catalogue/' . $className . '.php';
    return new $className();
  }

  public function getTemplate() {
    // TODO: Implement getTemplate() method.
  }

  protected function getFilePath($name) {
    return sprintf('%s/%s/%s', $this->configuration['dir'], $this->db, $name);
  }

  protected function readCount() {
    $countFile = $this->getFilePath('count.csv');
    $counts = readCsv($countFile);
    $counts = $counts[0];
    $this->count = isset($counts->processed) ? $counts->processed : $counts->total; // trim(file_get_contents($countFile));
  }

  protected function readLastUpdate() {
    $file = $this->getFilePath('last-update.csv');
    $this->lastUpdate = trim(file_get_contents($file));
  }

  protected function getSolrFieldMap() {
    $solrFieldMap = [];
    $fields = $this->getSolrFields($this->db);
    foreach ($fields as $field) {
      $parts = explode('_', $field);
      $solrFieldMap[$parts[0]] = $field;
    }

    return $solrFieldMap;
  }

  /**
   * @param array $db
   * @return array
   */
  protected function getSolrFields() {
    if (!isset($this->solrFields)) {
      $url = 'http://localhost:8983/solr/' . $this->db;
      $all_fields = file_get_contents($url . '/select/?q=*:*&wt=csv&rows=0');
      $this->solrFields = explode(',', $all_fields);
    }
    return $this->solrFields;
  }

  protected function getSolrResponse($params) {
    $url = 'http://localhost:8983/solr/' . $this->db . '/select?' . join('&', $this->encodeSolrParams($params));
    error_log($url);
    $solrResponse = json_decode(file_get_contents($url));
    $response = (object)[
      'numFound' => $solrResponse->response->numFound,
      'docs' => $solrResponse->response->docs,
      'facets' => (isset($solrResponse->facet_counts) ? $solrResponse->facet_counts->facet_fields : []),
      'params' => $solrResponse->responseHeader->params,
    ];

    return $response;
  }

  protected function getFacets($facet, $query, $limit, $offset = 0) {
    error_log('getFacets');
    $parameters = [
      'q=' . $query,
      'facet=on',
      'facet.limit=' . $limit,
      'facet.offset=' . $offset,
      'facet.field=' . $facet,
      'facet.mincount=1',
      'core=' . $this->db,
      'rows=0',
      'wt=json',
      'json.nl=map',
    ];
    error_log(join('  ', $parameters));
    $response = $this->getSolrResponse($parameters);
    return $response->facets;
  }

  private function encodeSolrParams($parameters) {
    $encodedParams = [];
    foreach ($parameters as $parameter) {
      if ($parameter == '')
        continue;

      list($k, $v) = explode('=', $parameter);
      if ($k == 'core' || $k == '_'  || $k == 'json.wrf' || $v == '') { //
        continue;
      }
      if ($k == 'q') {
        error_log($v);
      }
      if (!preg_match('/%/', $v))
        $v = urlencode($v);

      $encodedParams[] = $k . '=' . $v;
    }
    $encodedParams[] = 'indent=false';
    return $encodedParams;
  }

  protected function readHistogram($histogramFile) {
    $records = [];
    if (file_exists($histogramFile)) {
      $records = readCsv($histogramFile);
      $records = array_filter($records, function($record) {
        return ($record->name != 'id' && $record->name != 'total');
      });
    }
    return $records;
  }

  protected function getSelectedFacets() {
    $selectedFacets = [];
    $file = 'cache/selected-facets-' . $this->db . '.js';
    if (file_exists($file)) {
      $facets = file_get_contents($file);
    } elseif (file_exists('cache/selected-facets.js')) {
      $facets = file_get_contents('cache/selected-facets.js');
    }
    if (!is_null($facets)) {
      $facets = preg_replace(['/var selectedFacets = /', '/;$/', '/\'/'], ['', '', '"'], $facets);
      $selectedFacets = json_decode($facets);
    }
    return $selectedFacets;
  }

  protected function getSolrField($tag, $subfield = '') {
    if (!isset($this->fieldDefinitions))
      $this->fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

    if ($subfield == '')
      list($tag, $subfield) = explode('$', $tag);

    $solrField = $tag . $subfield;
    if (isset($this->fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr)) {
      $solrField = $this->fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr . '_ss';
    } elseif (isset($this->fieldDefinitions->fields->{$tag}->solr)) {
      $solrField = $tag . $subfield
                 . '_' . $this->fieldDefinitions->fields->{$tag}->solr
                 . '_' . $subfield . '_ss';
    }
    return $solrField;
  }

  public function resolveSolrField($solrField) {
    if (!isset($this->fieldDefinitions))
      $this->fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

    $solrField = preg_replace('/_ss$/', '', $solrField);
    if ($solrField == 'type' || substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
      $found = false;
      if (substr($solrField, 0, 2) == '00') {
        $parts = explode('_', $solrField);
        foreach ($this->fieldDefinitions->fields->{$parts[0]}->types as $name => $type)
          foreach ($type->positions as $position => $definition)
            if ($position == $parts[1]) {
              $label = sprintf('%s/%s %s', $parts[0], $parts[1], $definition->label);
              $found = true;
              break;
            }
      }
      if (!$found) {
        $solrField = preg_replace('/^(00.|Leader)_/', "$1/", $solrField);
        $solrField = preg_replace('/_/', ' ', $solrField);
        $label = $solrField;
      }
    } else {
      $label = sprintf('%s$%s', substr($solrField, 0, 3), substr($solrField, 3, 1));
      foreach ($this->fieldDefinitions->fields as $field)
        if (isset($field->subfields))
          foreach ($field->subfields as $code => $subfield)
            if ($subfield->solr == $solrField) {
              $label = sprintf('%s$%s %s', $field->tag, $code, $field->label);
              if ($field->label != $subfield->label)
                $label .= ' / ' . $subfield->label;
              break;
            }
    }
    return $label;
  }

  protected function solrToMarcCode($solrField) {
    $solrField = preg_replace('/_ss$/', '', $solrField);
    if ($solrField == 'type' || substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
      if (substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
        $parts = explode('_', $solrField);
        $label = sprintf('%s/%s', $parts[0], $parts[1]);
      } else {
        $label = $solrField;
      }
    } else {
      $label = sprintf('%s$%s', substr($solrField, 0, 3), substr($solrField, 3, 1));
    }
    return $label;
  }
}