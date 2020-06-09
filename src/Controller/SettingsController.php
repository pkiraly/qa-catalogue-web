<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends BaseController
{
  /**
   * @Route("/settings")
   */
  public function run() {
    $number = 3;
    $this->selectTab('settings');
    return $this->render('settings/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }
}