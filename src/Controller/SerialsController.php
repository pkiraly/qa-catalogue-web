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
      'prefix' => 'serial-score',
      'histogram' => $this->readHistogram(), // 'serial-histogram.tpl'
    ]);
  }

  private function read() {
    $data = [];

    return $data;
  }

  private function readHistogram() {
    $data = [];
    $byRecordsFile = $this->getDir() .  '/serial-score-fields.csv';
    if (file_exists($byRecordsFile)) {
      $header = [];
      $records = [];
      $in = fopen($byRecordsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          if ($record->name != 'id' && $record->name != 'total')
            $records[] = $record;
        }
      }
      $data['fields'] = $records;
    }
    return $data;
  }

}