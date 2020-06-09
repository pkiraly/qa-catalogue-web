<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class TermsController extends BaseController
{
  /**
   * @Route("/terms")
   */
  public function run() {
    $number = 3;
    $this->selectTab('terms');
    return $this->render('terms/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}