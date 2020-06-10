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
    'selected_tab' => '',
    'db' => 'gent',
    'dir' => '/home/kiru/bin/marc/_output/'
  ];

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

  protected function getOrDefault(Request $request, $key, $default_value, $allowed_values) {
    $value = $request->query->get($key);
    if (is_null($value) || !in_array($value, $allowed_values)) {
      $value = $default_value;
    }
    return $value;
  }

  protected function getSolrFields() {
    $url = 'http://localhost:8983/solr/' . $this->commons['db'];
    $all_fields = file_get_contents($url . '/select/?q=*:*&wt=csv&rows=0');
    $fields = explode(',', $all_fields);
    return $fields;
  }
}