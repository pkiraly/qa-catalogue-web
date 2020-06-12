<?php

namespace App\Twig;

use App\Controller\BaseController;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class AppExtension extends AbstractExtension
{
  public function getFunctions() {
    return [
      new TwigFunction('gettype', 'gettype'),
      new TwigFunction('json_encode', 'json_encode'),

      new TwigFunction('getFacetLabel', [$this, 'getFacetLabel']),
      new TwigFunction('getRecord', [$this, 'getRecord']),
      new TwigFunction('getField', [$this, 'getField']),
      new TwigFunction('getFirstField', [$this, 'getFirstField']),
      new TwigFunction('type2icon', [$this, 'type2icon']),
      new TwigFunction('to_array', [$this, 'to_array']),
    ];
  }

  public function to_array($obj) {
    return (array) $obj;
  }

  public function type2icon($type) {
    switch ($type) {
      case 'Books': $icon = 'book'; break;
      case 'Maps': $icon = 'map'; break;
      case 'Computer Files': $icon = 'save'; break;
      case 'Music': $icon = 'music'; break;
      case 'Continuing Resources': $icon = 'clone'; break;
      case 'Visual Materials': $icon = 'image'; break;
      case 'Mixed Materials': $icon = 'archive'; break;
    }
    return $icon;
  }

  public function getFacetLabel($facet) {
    $ctr = new BaseController();
    return $ctr->getFacetLabel($facet);
  }

  public function getRecord($doc) {
    return json_decode($doc->record_sni);
  }

  public function getField($record, $fieldName) {
    if (isset($record->{$fieldName}))
      return $record->{$fieldName}[0];
    return null;
  }

  public function getFirstField($doc, $fieldName, $withSpaceReplace = FALSE) {
    $value = null;
    if (isset($doc->{$fieldName})) {
      $value = $doc->{$fieldName}[0];
      if ($withSpaceReplace) {
        $value = str_replace(" ", "&nbsp;", $value);
      }
    }
    return $value;
  }
}