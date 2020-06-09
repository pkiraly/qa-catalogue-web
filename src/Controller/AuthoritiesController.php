<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class AuthoritiesController extends BaseController
{
  /**
   * @Route("/authorities")
   */
  public function run() {
    $number = 3;
    $this->selectTab('authorities');
    return $this->render('authorities/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}