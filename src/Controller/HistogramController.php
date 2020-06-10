<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HistogramController extends BaseController
{
  private $allowable_histograms = [
    'authorities-histogram' => ['name' => 'count', 'limit' => 30],
    'classifications-histogram' => ['name' => 'count', 'limit' => 30],
    'serial-histogram' => ['name' => 'score', 'limit' => 40],
    'tt-completeness-histogram-total' => ['name' => 'count', 'limit' => 40],
    'serial-score-histogram-total' => ['name' => 'count', 'limit' => 40],
  ];

  private $tt_completeness_suffixes = [
    'isbn', 'authors', 'alternative-titles', 'edition', 'contributors', 'series',
    'toc-and-abstract', 'date-008', 'date-26x', 'classification-lc-nlm',
    'classification-loc', 'classification-mesh', 'classification-fast',
    'classification-gnd', 'classification-other', 'online', 'language-of-resource',
    'country-of-publication', 'no-language-or-english', 'rda'
  ];

  private $serial_score_suffixes = [
    'date1-unknown', 'country-unknown', 'language', 'auth', 'enc-full', 'enc-mlk7',
    '006', '260', '264', '310', '336', '362', '588', 'no-subject', 'has-subject',
    'pcc', 'date1-0', 'abbreviated'
  ];

  /**
   * @Route("/histogram")
   */
  public function run(Request $request) {
    $this->initialize();
    $filename = $this->getOrDefault($request, 'file', '', array_keys($this->allowable_histograms));
    $response = new Response($this->read($filename));
    $response->headers->set('Content-Type', 'text/csv');

    return $response;
  }

  private function read($filename) {

    $content = '';
    if ($filename != '') {
      $absoluteFilePath = $this->getDir() . sprintf('/%s.csv', $filename);
      $limit = $this->allowable_histograms[$filename]['limit'];
      $field_name = $this->allowable_histograms[$filename]['name'];
      if (file_exists($absoluteFilePath)) {
        $max = 0;
        $lastBucket = 0;
        $in = fopen($absoluteFilePath, "r");
        while (($line = fgets($in)) != false) {
          $values = str_getcsv($line);
          if (empty($header)) {
            $header = $values;
            $content .= $line;
          } else {
            $record = (object)array_combine($header, $values);
            $max = $record->{$field_name};
            if ($record->{$field_name} >= $limit) {
              $lastBucket += $record->frequency;
            } else {
              $content .= $line;
            }
          }
        }
        if ($lastBucket != 0) {
          $content .= sprintf(
            "%s,%d\n",
            (($max > $limit) ? $limit . '-' . $max : $max),
            $lastBucket
          );
        }
      }
    }
    return $content;
  }

  private function initialize() {
    foreach ($this->tt_completeness_suffixes as $suffix) {
      $this->allowable_histograms['tt-completeness-histogram-' . $suffix] = [
        'name' => 'count', 'limit' => 10
      ];
    }

    foreach ($this->serial_score_suffixes as $suffix) {
      $this->allowable_histograms['serial-score-histogram-' . $suffix] = [
        'name' => 'count', 'limit' => 10
      ];
    }
  }

}