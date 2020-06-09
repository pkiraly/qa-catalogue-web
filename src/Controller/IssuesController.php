<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class IssuesController extends BaseController
{
  /**
   * @Route("/issues")
   */
  public function run() {
    $number = 3;
    $this->selectTab('issues');
    return $this->render('issues/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}