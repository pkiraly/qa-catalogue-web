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
      'files' => $this->listFiles(),
    ]);
  }

  private function listFiles() {
    $projectDir = $this->getParameter('kernel.project_dir');
    $raw_files = scandir(sprintf('%s/public/img/%s/', $projectDir, $this->commons['db']));
    $files = [];
    foreach ($raw_files as $file) {
      if (preg_match('/\.png$/', $file)) {
        $files[] = $file;
      }
    }
    return $files;
  }
}