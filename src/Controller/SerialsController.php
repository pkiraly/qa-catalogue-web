<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class SerialsController extends BaseController
{
  /**
   * @Route("/serials")
   */
  public function run() {
    $number = 3;
    $this->selectTab('serials');
    return $this->render('serials/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}