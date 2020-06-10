<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FunctionsController extends BaseController
{
  /**
   * @Route("/functions")
   */
  public function run() {
    $number = 3;
    $this->selectTab('functions');
    return $this->render('functions/main.html.twig', [
      'commons' => $this->commons,
      'number' => $number,
    ]);
  }

  /**
   * @Route("/functions/data")
   */
  public function readDataAction() {
    $response = new Response($this->readData());
    $response->headers->set('Content-Type', 'text/csv');

    return $response;
  }

  public function readData() {
    $elementsFile = $this->getDir() . '/functional-analysis-histogram.csv';
    $groupped_csv = [];
    if (file_exists($elementsFile)) {
      $lineNumber = 0;
      $header = [];
      $in = fopen($elementsFile, "r");
      while (($line = fgets($in)) != false) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          // frbrfunction, score, count
          $header = $values;
          $current_function = '';
          $function_report = [];
          $groupped_csv[] = $header;
        } else {
          if (count($header) != count($values)) {
            error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
          }
          $record = (object)array_combine($header, $values);
          if ($record->frbrfunction != $current_function) {
            if ($current_function != '') {
              $this->add_function_report($current_function, $function_report, $groupped_csv);
            }
            $function_report = [];
            $current_function = $record->frbrfunction;
          }

          $rounded = round($record->score * 100);
          if (!isset($function_report[$rounded])) {
            $function_report[$rounded] = $record->count;
          } else {
            $function_report[$rounded] += $record->count;
          }
        }
      }
      $this->add_function_report($current_function, $function_report, $groupped_csv);
      fclose($in);
    }

    return $this->format_as_csv($groupped_csv);
  }

  private function add_function_report($current_function, $function_report, &$groupped_csv) {
    foreach ($function_report as $score => $count) {
      $groupped_csv[] = [$current_function, $score, $count];
    }
  }

  private function format_as_csv($groupped_csv) {
    $lines = [];
    foreach ($groupped_csv as $row) {
      $lines[] = join(',', $row);
    }
    return join("\n", $lines);
  }
}