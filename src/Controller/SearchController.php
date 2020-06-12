<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends BaseController
{
  private $query = '*:*';
  private $fq = [];
  private $filters = null;
  private $start = 0;
  private $rows = 10;
  private $facets = [];
  private $url = null;

  private $defaultFacets = [
    '041a_Language_ss',
    '040b_AdminMetadata_languageOfCataloging_ss',
    'Leader_06_typeOfRecord_ss',
    'Leader_18_descriptiveCatalogingForm_ss'
  ];

  private $defaultSolrParameters = [
    'wt=json',
    'json.nl=map',
    // 'json.wrf=?',
    'facet=on',
    'facet.limit=10'
  ];

  /**
   * @Route("/search", name="search")
   */
  public function run(Request $request) {
    $errorId = $request->query->get('error-id');
    if (!is_null($errorId) && preg_match('/^\d+$/', $errorId)) {
      $ids = $this->getRecordIdsByErrorId($errorId);
      $this->query = join(' OR ', $ids);
    } else {
      $field = $this->getOrDefault($request, 'field', '', []);
      if ($field != '') {
        $this->fq = $this->byfield($field) . ':*';
      } else {
        $query = $this->getOrDefault($request, 'query', '', []);
        if ($query != '')
          $this->query = $request->query->get('query');
      }
    }
    $solrResponse = $this->getSolrResponse();

    $this->selectTab('search');
    return $this->render('search/main.html.twig', [
      'commons' => $this->commons,
      'query' => $this->query,
      'filters' => $this->filters,
      'url' => $this->url,
      'result' => $solrResponse,
      'numFound' => $solrResponse->response->numFound,
      // 'records' => getRecords($solrResponse),
      // 'facets' => $this->getFacets($solrResponse), // 'marc-facets.tpl'
      'docs' => $solrResponse->response->docs, // 'marc-records-based-on-marcjson.tpl'
      'facets' => $solrResponse->facet_counts->facet_fields,
      'params' => $solrResponse->responseHeader->params
    ]);
  }

  private function getSolrResponse() {
    $this->url = $this->buildSolrUrl();
    $json = file_get_contents($this->url);
    error_log(substr($json, 0, 100));
    $response = json_decode($json);

    if (isset($response->facet_counts) && isset($response->facet_counts->facet_fields)) {
      foreach ($response->facet_counts->facet_fields as $field => $list) {
        $response->facet_counts->facet_fields->{$field} = (array)$list;
      }
      $response->facet_counts->facet_fields = (array) $response->facet_counts->facet_fields;
    }
    return $response;
  }

  private function buildSolrUrl() {
    $params = [
      'q=' . $this->query,
      'start=' . $this->start,
      'rows=' . $this->rows,
    ];
    error_log('status 1: ' . count($params));

    $params = array_merge($params, $this->defaultSolrParameters);
    error_log('status 2: ' . count($params));

    if (!empty($this->fq))
      foreach ($this->fq as $fq)
        $params[] = 'fq=' . $fq;
    error_log('status 3: ' . count($params));

    // $params += $parameters;
    error_log('before: ' . count($params));
    $params = array_merge($params, $this->buildFacetParameters());
    error_log('after: ' . count($params));
    error_log('status 4: ' . count($params));

    if (!empty($this->filters))
      $params = array_merge($params, $this->filters);
    error_log('status 5: ' . count($params));

    return $this->getSolrBaseUrl() . '/select?' . join('&', $params);
  }

  private function buildFacetParameters() {
    error_log('buildFacetParameters');

    $facetParameters = [];
    foreach ($this->facets as $facet)
      $facetParameters[] = 'facet.field=' . $facet;

    foreach ($this->defaultFacets as $facet)
      $facetParameters[] = 'facet.field=' . $facet;

    if (!empty($facetParameters))
      $facetParameters[] = 'facet.mincount=1';

    error_log(count($facetParameters));
    return $facetParameters;
  }

  public function getRecordIdsByErrorId($errorId) {
    $elementsFile = $this->getDir() . '/issue-collector.csv';
    $recordIds = [];
    $types = [];
    $max = 0;
    if (file_exists($elementsFile)) {
      // $keys = ['errorId', 'recordIds']
      $lineNumber = 0;
      $header = [];
      $in = fopen($elementsFile, "r");
      while (($line = fgets($in)) != false) {
        if (count($recordIds) < 10) {
          $lineNumber++;
          if ($lineNumber == 1) {
            $header = str_getcsv($line);
          } else {
            if (preg_match('/^' . $errorId . ',/', $line)) {
              $values = str_getcsv($line);
              $record = (object)array_combine($header, $values);
              $recordIds = explode(';', $record->recordIds);
              $recordIds = array_slice($recordIds, 0, 10);
              break;
            }
          }
        }
      }
      fclose($in);
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }

    return $recordIds;
  }

  private function getFacets($solrResponse) {
    return [
      'facets' => $solrResponse->facet_counts->facet_fields,
      'params' => $solrResponse->responseHeader->params
    ];
  }

  private function byfield($field) {
    $filters = [];
    $filters[] = [
      'param' => ['field' => $field],
      'label' => $this->getFacetLabel($field) . ': *'
    ];
    return $filters;
  }
}