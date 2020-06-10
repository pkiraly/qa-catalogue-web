<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class IssuesController extends BaseController
{
  private $marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
  private $total = 0;

  /**
   * @Route("/issues")
   */
  public function run() {
    $number = 3;
    $this->selectTab('issues');
    // $request->query->get('query');

    // $smarty->registerPlugin("function", "showMarcUrl", "showMarcUrl");

    return $this->render(
      'issues/main.html.twig',
      ['commons' => $this->commons] + $this->readVariables()
    );
  }

  private function readVariables() {
    $elementsFile = $this->getDir() . '/issue-summary.csv';
    $records = [];
    $types = [];
    $max = 0;
    if (file_exists($elementsFile)) {
      // $keys = ['path', 'type', 'message', 'url', 'count']; // "sum",
      // control subfield: invalid value
      $lineNumber = 0;
      $header = [];
      $typeCounter = [];

      foreach (file($elementsFile) as $line) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
          $header[1] = 'path';
        } else {
          if (count($header) != count($values)) {
            error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
          }
          $record = (object)array_combine($header, $values);
          $type = $record->type;
          unset($record->type);
          $record->url = $this->showMarcUrl($record->url);

          if (!isset($records[$type])) {
            $records[$type] = [];
          }
          if (count($records[$type]) < 100) {
            $records[$type][] = $record;
          }
          if (!isset($typeCounter[$type])) {
            $typeCounter[$type] = (object)[
              'instances' => 0,
              'records' => 0,
              'variations' => 0
            ];
          }
          $typeCounter[$type]->instances += $record->instances;
          $typeCounter[$type]->records += $record->records;
          $typeCounter[$type]->variations++;
        }
      }

      $types = array_keys($records);
      $mainTypes = [];
      foreach ($types as $type) {
        list($mainType, $subtype) = explode(': ', $type);
        if (!isset($mainTypes[$mainType])) {
          $mainTypes[$mainType] = [];
        }
        $mainTypes[$mainType][] = $type;
        uasort($records[$type], array($this, 'issueCmp'));
        // error_log(json_encode($records[$type]));
      }
      $orderedCategories = ['record', 'control subfield', 'field', 'indicator', 'subfield'];
      $categories = [];
      foreach ($orderedCategories as $category) {
        if (isset($mainTypes[$category])) {
          asort($mainTypes[$category]);
          $categories[$category] = $mainTypes[$category];
        }
      }

      return [
        'records' => $records,
        'categories' => $categories,
        'topStatistics' => $this->readIssueTotal(),
        'total' => $this->total,
        'typeStatistics' => $this->readTypes(),
        'categoryStatistics' => $this->readCategories(),
        'fieldNames' => ['path', 'message', 'url', 'instances', 'records'],
        'typeCounter' => $typeCounter
      ];
    }
  }

  private function readIssueTotal() {
    $statistics = $this->readIssueCsv('issue-total.csv', 'type');
    foreach ($statistics as $item) {
      if ($item->type != 2) {
        $this->total += $item->records;
      }
    }
    foreach ($statistics as &$item) {
      $item->percent = ($item->records / $this->total) * 100;
    }

    return [
      'all' => $statistics[1],
      'core' => $statistics[2]
    ];
  }

  private function readCategories() {
    return $this->readIssueCsv('issue-by-category.csv', 'category');
  }

  private function readTypes() {
    return $this->readIssueCsv('issue-by-type.csv', 'type');
  }

  private function readIssueCsv($filename, $keyField) {
    $elementsFile = $this->getDir() . '/' . $filename;
    $records = [];
    if (file_exists($elementsFile)) {
      $header = null;
      foreach (file($elementsFile) as $line) {
        $values = str_getcsv($line);
        if (is_null($header)) {
          $header = $values;
        } else {
          if (count($header) != count($values)) {
            error_log(count($header) . ' vs ' . count($values));
          }
          $record = (object)array_combine($header, $values);
          $key = $record->{$keyField};
          // unset($record->{$keyField});
          $records[$key] = $record;
        }
      }
    } else {
      error_log($elementsFile . ' does not exist!');
    }
    return $records;
  }

  private function issueCmp($a, $b) {
    $res = $this->cmp($b->records, $a->records);
    if ($res == 0) {
      $res = $this->cmp($a->path, $b->path);
    }
    return $res;
  }

  private function cmp($a, $b) {
    if ($a == $b) {
      return 0;
    }
    return ($a < $b) ? -1 : 1;
  }

  private function showMarcUrl($content) {
    if (!preg_match('/^http/', $content))
      $content = $this->marcBaseUrl . $content;

    return $content;
  }

}