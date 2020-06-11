<?php

namespace App\Twig;

use App\Controller\BaseController;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class AppExtension extends AbstractExtension
{
  public function getFunctions() {
    return [
      new TwigFunction('getFacetLabel', [$this, 'getFacetLabel']),
    ];
  }

  public function getFacetLabel($facet) {
    $ctr = new BaseController();
    return $ctr->getFacetLabel($facet);
  }
}