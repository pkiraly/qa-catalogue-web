<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
  protected $commons = [
    'tabs' => [
      'about' => ['class' => '', 'selected' => 'false'],
      'authorities' => ['class' => '', 'selected' => 'false'],
      'classifications' => ['class' => '', 'selected' => 'false'],
      'completeness' => ['class' => '', 'selected' => 'false'],
      'functions' => ['class' => '', 'selected' => 'false'],
      'issues' => ['class' => '', 'selected' => 'false'],
      'pareto' => ['class' => '', 'selected' => 'false'],
      'search' => ['class' => '', 'selected' => 'false'],
      'serials' => ['class' => '', 'selected' => 'false'],
      'settings' => ['class' => '', 'selected' => 'false'],
      'terms' => ['class' => '', 'selected' => 'false'],
      'tt_completeness' => ['class' => '', 'selected' => 'false'],
    ],
    'facetLabels' => [
        '041a_Language_ss' => 'language',
        '040b_AdminMetadata_languageOfCataloging_ss' => 'language of cataloging',
        'Leader_06_typeOfRecord_ss' => 'record type',
        'Leader_18_descriptiveCatalogingForm_ss' => 'cataloging form',
        '650a_Topic_topicalTerm_ss' => 'topic',
        '650z_Topic_geographicSubdivision_ss' => 'geographic',
        '650v_Topic_formSubdivision_ss' => 'form',
        '6500_Topic_authorityRecordControlNumber_ss' => 'topic id',
        '6510_Geographic_authorityRecordControlNumber_ss' => 'geo id',
        '6550_GenreForm_authorityRecordControlNumber_ss' => 'genre id',
        '9129_WorkIdentifier_ss' => 'work id',
        '9119_ManifestationIdentifier_ss' => 'manifestation id'
    ],
    'selected_tab' => '',
    'db' => 'gent',
    'dir' => '/home/kiru/bin/marc/_output/'
  ];

  public function getDb() {
    return $this->commons['db'];
  }

  protected function selectTab($tab) {
    if (isset($this->commons['tabs'][$tab])) {
      $this->commons['tabs'][$tab]['class'] = 'active';
      $this->commons['tabs'][$tab]['selected'] = 'true';
      $this->commons['selected_tab'] = $tab;
    }
  }

  protected function getDir() {
    return sprintf('%s/%s', $this->commons['dir'], $this->commons['db']);
  }

  /**
   * @param Request $request
   * @param $key
   * @param string $default_value
   * @param array $allowed_values
   * @return bool|float|int|string
   */
  protected function getOrDefault(Request $request, $key, $default_value = '', $allowed_values = []) {
    $value = $request->query->get($key);
    if (is_null($value) || (!empty($allowed_values) && !in_array($value, $allowed_values))) {
      $value = $default_value;
    }
    return $value;
  }

  protected function getSolrBaseUrl() {
    return 'http://localhost:8983/solr/' . $this->commons['db'];
  }

  protected function getSolrFields() {
    $url = $this->getSolrBaseUrl();
    $all_fields = file_get_contents($url . '/select/?q=*:*&wt=csv&rows=0');
    $fields = explode(',', $all_fields);
    return $fields;
  }

  public function getFacetLabel($field) {
    if (isset($this->commons['facetLabels'][$field]))
      return $this->commons['facetLabels'][$field];
    $field = preg_replace('/_ss$/', '', $field);
    $field = preg_replace('/_/', ' ', $field);
    return $field;
  }
}