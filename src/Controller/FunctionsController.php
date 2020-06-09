<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class FunctionsController extends BaseController
{
  /**
   * @Route("/functions")
   */
  public function run() {
    $number = 3;
    $this->selectTab('functions');
    return $this->render('functions/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}