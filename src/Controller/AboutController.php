<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class AboutController extends BaseController
{
  /**
   * @Route("/about")
   */
  public function run() {
    $number = 3;
    $this->selectTab('about');
    return $this->render('about/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}