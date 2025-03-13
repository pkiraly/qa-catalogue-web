<?php

namespace Utils;

use Monolog\Logger;

class Solr {
  private string $indexName;
  private string $mainSolrEndpoint;
  private $solrFieldsFile;
  private ?string $solrForScoresUrl;
  private bool $showAdvancedSearchForm;
  private Logger $log;

  private $solrFields;

  /**
   * @param Configuration $configuration
   * @param $solrFieldsFile
   */
  public function __construct(Configuration $configuration, $solrFieldsFile) {
    $this->log = $configuration->createLogger(get_class($this));
    $this->indexName = $configuration->getIndexName();
    $this->mainSolrEndpoint = $configuration->getMainSolrEndpoint();
    $this->solrForScoresUrl = $configuration->getSolrForScoresUrl();
    $this->showAdvancedSearchForm = $configuration->doShowAdvancedSearchForm();
    $this->solrFieldsFile = $solrFieldsFile;
  }

  public function getSolrResponse($params): object {
    $url = $this->mainSolrEndpoint . $this->indexName . '/select?' . join('&', $this->encodeParams($params));
    $solrResponse = json_decode(file_get_contents($url));
    if (!$solrResponse) throw new \Exception("Solr request failed");
    return (object)[
      'numFound' => $solrResponse->response->numFound,
      'docs' => $solrResponse->response->docs,
      'facets' => (isset($solrResponse->facet_counts) ? $solrResponse->facet_counts->facet_fields : []),
      'facet_queries' => (isset($solrResponse->facet_counts) && isset($solrResponse->facet_counts->facet_queries) ? $solrResponse->facet_counts->facet_queries : []),
      'params' => $solrResponse->responseHeader->params,
    ];
  }

  public function hasValidationIndex(): bool {
    return $this->isCoreAvailable($this->indexName . '_validation');
  }

  /**
   * @param $core The name of the Solr core
   * @return bool
   */
  public function isCoreAvailable($core): bool {
    $endpoint = $this->getEndpoint($core);
    if (is_null($endpoint))
      return false;

    $url = $this->getEndpoint($core) . $core . '/admin/ping';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $content = curl_exec($ch);
    $info = curl_getinfo($ch);
    $http_code = $info["http_code"];
    curl_close($ch);
    if ($http_code == 200) {
      $response = json_decode($content);
      return ($response->status == 'OK');
    }
    return false;
  }

  public function countTotalFacets($facet, $query, $termFilter = '', $filters = []) {
    $limit = 10000;
    $offset = 0;
    $total = 0;
    do {
      $facets = $this->getFacets($facet, $query, $limit, $offset, $termFilter, $filters);
      $count = count((array) $facets->{$facet});
      $total += $count;
      $offset += $limit;
    } while ($count == $limit);

    return $total;
  }

  public function getFacets($facet, $query, $limit, $offset = 0, $termFilter = '', $filters = []) {
    $parameters = [
      'q=' . $query,
      'facet=on',
      'facet.limit=' . $limit,
      'facet.offset=' . $offset,
      'facet.field=' . $facet,
      'facet.mincount=1',
      'core=' . $this->indexName,
      'rows=0',
      'wt=json',
      'json.nl=map',
    ];
    if (!empty($termFilter)) {
      $parameters[] = sprintf('f.%s.facet.contains=%s', $facet, $termFilter);
      $parameters[] = sprintf('f.%s.facet.contains.ignoreCase=true', $facet);
    }
    if (!empty($filters))
      foreach ($filters as $filter)
        $parameters[] = 'fq=' . $filter;

    return $this->getSolrResponse($parameters)->facets;
  }

  public function getQueryFacets($query, $facetQueries, $limit = 100, $offset = 0, $termFilter = '', $filters = []) {
    $parameters = array_merge([
      $query,
      'facet=on',
      'facet.limit=' . $limit,
      'facet.offset=' . $offset,
      'core=' . $this->indexName,
      'rows=0',
      'wt=json',
      'json.nl=map',
    ], $facetQueries);

    if (!empty($filters))
      foreach ($filters as $filter)
        $parameters[] = 'fq=' . $filter;

    return $this->getSolrResponse($parameters)->facet_queries;
  }

  public function searchFacets($params) {
    $url = $this->mainSolrEndpoint . $this->indexName . '/select?' . $params;
    $response = json_decode(file_get_contents($url));
    if ($response && isset($response->facet_counts)) {
      return $response->facet_counts->facet_fields;
    } else {
      return (object)[];
    }
  }


  public function getSolrModificationDate(): string {
    $url = $this->mainSolrEndpoint . 'admin/cores?action=STATUS&core=' . $this->indexName;
    $response = json_decode(file_get_contents($url));
    $lastModified = $response->status->{$this->indexName}->index->lastModified;
    return date("Y-m-d H:i:s", strtotime($lastModified));
  }

  /**
   * @return array
   */
  public function getSolrFields($onlyStored = false) {
    if (!isset($this->solrFields)) {
      if ($onlyStored)
        $this->getSolrFieldsByQuery();
      else
        $this->getSolrFieldsFromLuke();
    }
    return $this->solrFields;
  }

  /**
   * Returns only the stored Solr fields
   * @return array|false|string[]
   */
  protected function getSolrFieldsByQuery() {
    if (!isset($this->solrFields)) {
      $baseUrl = $this->mainSolrEndpoint . $this->indexName;
      $url = $baseUrl . '/select/?q=*:*&wt=csv&rows=0';
      $all_fields = file_get_contents($url);
      $this->solrFields = explode(',', $all_fields);
      if ($this->showAdvancedSearchForm) {
        $tokenizedVersions = [];
        foreach ($this->solrFields as $field) {
          if (preg_match('/_ss$/', $field))
            $tokenizedVersions[] = preg_replace('/_ss$/', '_tt', $field);
        }
        $this->solrFields = array_merge($this->solrFields, $tokenizedVersions);
      }
    }
    return $this->solrFields;
  }

  /**
   * Returns all Solr fields (stored and not stored as well)
   * @return string[]
   */
  protected function getSolrFieldsFromLuke(): array {
    if (!isset($this->solrFields)) {
      if (file_exists($this->solrFieldsFile) && filesize($this->solrFieldsFile) > 0) {
        $this->solrFields = json_decode(file_get_contents($this->solrFieldsFile));
      } else {
        $baseUrl = $this->mainSolrEndpoint . $this->indexName;
        $url = $baseUrl . '/admin/luke?wt=json';
        $luke = json_decode(file_get_contents($url));
        $this->solrFields = array_keys(get_object_vars($luke->fields));
      }
    }
    return $this->solrFields;
  }

  public function getEndpoint($core): ?string {
    return preg_match('/validation$/', $core) ? $this->solrForScoresUrl : $this->mainSolrEndpoint;
  }

  private function encodeParams($parameters): array {
    if (array_is_list($parameters))
      return $this->encodeList($parameters);
    else
      return $this->encodeAssocArray($parameters);
  }

  private function encodeList($parameters): array {
    $encodedParams = [];
    foreach ($parameters as $parameter) {
      if ($parameter == '')
        continue;

      list($k, $v) = explode('=', $parameter);
      if ($this->isSkippable($k, $v))
        continue;

      if (!preg_match('/%/', $v))
        $v = urlencode($v);

      $encodedParams[] = $k . '=' . $v;
    }
    $encodedParams[] = 'indent=false';
    return $encodedParams;
  }

  private function encodeAssocArray($parameters): array {
    $encodedParams = [];
    foreach ($parameters as $k => $v) {
      if ($this->isSkippable($k, $v))
        continue;

      if (!preg_match('/%/', $v))
        $v = urlencode($v);

      $encodedParams[] = $k . '=' . $v;
    }
    $encodedParams[] = 'indent=false';
    return $encodedParams;
  }

  private function isSkippable($k, $v): bool {
    return ($k == 'core' || $k == '_'  || $k == 'json.wrf' || $v == '');
  }
}
