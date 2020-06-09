<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class SearchController extends BaseController
{
  /**
   * @Route("/search")
   */
  public function run() {
    $number = 3;
    $this->selectTab('search');
    return $this->render('search/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}