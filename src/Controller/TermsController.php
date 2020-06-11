<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TermsController extends BaseController
{
  /**
   * @Route("/terms", name="terms")
   */
  public function run(Request $request) {
    $facet = $this->getOrDefault($request, 'facet', '', []);
    $termQuery = $this->getOrDefault($request, 'termQuery', '', []);
    $scheme = $this->getOrDefault($request, 'scheme', '', []);
    $url = $this->getSolrUrl($termQuery, $facet);
    $solrResponse = $this->getSolrResponse($termQuery, $facet);

    $this->selectTab('terms');
    return $this->render('terms/main.html.twig', [
      'commons' => $this->commons,
      'facet' => $facet,
      'termQuery' => $termQuery,
      'scheme' => $scheme,
      'url' => $url,
      'facets' => (array)$solrResponse->facet_counts->facet_fields,
      'params' => $solrResponse->responseHeader->params,
    ]);
  }

  private function getSolrResponse($termQuery, $facet) {
    $url = $this->getSolrUrl($termQuery, $facet);
    $response = json_decode(file_get_contents($url));
    foreach ($response->facet_counts->facet_fields as $field => $list) {
      $response->facet_counts->facet_fields->{$field} = (array)$list;
    }

    return $response;
  }

  private function getSolrUrl($termQuery, $facet) {
    $params = [
      'q=' . $termQuery,
      'facet=on',
      'facet.limit=100',
      'facet.field=' . trim($facet),
      'facet.mincount=1',
      'core=' . $this->commons['db'],
      'rows=0',
      'wt=json',
      'json.nl=map'
    ];

    return $this->getSolrBaseUrl() . '/select?' . join('&', $params);
  }
}