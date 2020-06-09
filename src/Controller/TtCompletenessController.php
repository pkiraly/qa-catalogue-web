<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class TtCompletenessController extends BaseController
{
  /**
   * @Route("/tt-completeness")
   */
  public function run() {
    $number = 3;
    $this->selectTab('tt_completeness');
    return $this->render('tt_completeness/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}