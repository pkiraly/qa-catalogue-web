<?php

class Collocations extends BaseTab {

  private $facet1;
  private $facet2;
  private $type;
  private $position;
  private $baseParams;

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $this->facet1 = getOrDefault('facet1', '', $this->getFields());
    $this->facet2 = getOrDefault('facet2', '', $this->getFields());
    $this->baseParams = [
      'tab=data',
      'query=' . urlencode('*:*'),
      'facet=',
      'start=0',
      'rows=10'
    ];

    $smarty->assign('facet1', $this->facet1);
    $smarty->assign('facet2', $this->facet2);
    $smarty->assign('solrFields', $this->getFields());
    $smarty->assign('results', $this->collocateFields());
  }

  public function getTemplate() {
    return 'collocations.tpl';
  }

  public function getAjaxTemplate() {
    return null;
  }

  private function collocateFields() {
    $params = 'q=*:*&start=0&rows=0&wt=json&q.op=AND&json.nl=map&facet=on&facet.limit=100&facet.mincount=1';
    $params .= '&facet.field=' . $this->facet1;
    $params .= '&facet.field=' . $this->facet2;

    $response = $this->search($params);

    $results = [];
    $f1_values = $response->facets->{$this->facet1};
    foreach ($f1_values as $value1 => $count1) {
      $response = $this->search($params . '&fq=' . $this->facet1 . ':' . urlencode('"' . $value1 . '"'));
      foreach ($response->facets->{$this->facet2} as $value2 => $count2) {
        $results[] = [$value1, $value2, $count2, $this->createSearchUrl($value1, $value2)];
        if (count($results) > 1000)
          break;
      }
    }
    return $results;
  }

  private function createSearchUrl($value1, $value2) {
    $params = [
      'filters[]=' . $this->formatQuery($this->facet1, $value1),
      'filters[]=' . $this->formatQuery($this->facet2, $value2),
    ];
    return '?' . implode('&', array_merge($this->baseParams, $params));
  }

  private function formatQuery($field, $value) {
    return urlencode(sprintf('%s:"%s"', $field, $value));
  }

  private function search($params) {
    $solrPath = $this->getIndexName();
    $url = 'http://localhost:8983/solr/' . $solrPath . '/select?' . $params;
    $solrResponse = json_decode(file_get_contents($url));
    $response = (object)[
      'numFound' => $solrResponse->response->numFound,
      'docs' => $solrResponse->response->docs,
      'facets' => (isset($solrResponse->facet_counts) ? $solrResponse->facet_counts->facet_fields : []),
      'params' => $solrResponse->responseHeader->params,
    ];

    return $response;
  }

  function str_putcsv(array $input, $delimiter = ',', $enclosure = '"') {
    $fp = fopen('php://temp', 'r+b');

    fputcsv($fp, $input, $delimiter, $enclosure);
    rewind($fp);
    $data = rtrim(stream_get_contents($fp), "\n");
    fclose($fp);
    return $data;
  }


  private function asCsv($terms) {
    header("Content-type: text/csv");
    echo $this->formatAsCsv($terms);
  }

  private function formatAsCsv($terms) {
    $lines = ['term,count'];
    foreach ($terms as $key => $value)
      $lines[] = sprintf('"%s",%d', $key, $value);

    return join("\n", $lines);
  }

  private function getFields() {
    error_log('getFields');
    $fieldNames = $this->getSolrFields();
    error_log('nr: ' . count($fieldNames));
    sort($fieldNames);
    error_log('nr: ' . count($fieldNames));
    return $fieldNames;
  }
}