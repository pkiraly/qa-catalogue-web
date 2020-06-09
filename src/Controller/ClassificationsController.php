<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ClassificationsController extends BaseController
{
  /**
   * @Route("/classifications")
   */
  public function run() {
    $number = 3;
    $this->selectTab('classifications');
    return $this->render('classifications/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}