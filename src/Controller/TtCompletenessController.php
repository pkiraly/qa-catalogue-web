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
      'prefix' => 'tt-completeness',
      'histogram' => $this->readHistogram(), // 'tt-completeness-histogram.tpl'
    ]);
  }

  private function readHistogram() {
    $data = [];
    $byRecordsFile = $this->getDir() . '/tt-completeness-fields.csv';
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