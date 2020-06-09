<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ParetoController extends BaseController
{
  /**
   * @Route("/pareto")
   */
  public function run() {
    $number = 3;
    $this->selectTab('pareto');
    return $this->render('pareto/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}