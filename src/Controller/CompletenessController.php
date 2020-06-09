<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class CompletenessController extends BaseController
{
  private $fieldDefinitions = null;
  private $count = null;

  /**
   * @Route("/completeness")
   */
  public function run() {
    $this->count = $this->getCount();
    $this->fieldDefinitions = $this->getFieldDefinitions();

    $this->selectTab('completeness');
    return $this->render('completeness/main.html.twig', [
      'commons' => $this->commons,
      'number' => $this->count,
      'packageStatistics' => $this->getPackageStatistics(),
      'dataElementStatistics' => $this->getDataElementStatistics(),
      // 'project_dir' => $projectDir = $this->getParameter('kernel.project_dir'),
      // 'marc_dir' => $projectDir = $this->getParameter('app.marc_dir'),
    ]);
  }

  private function getFieldDefinitions() {
    $fieldmapFile = $this->getParameter('kernel.project_dir') . '/public/fieldmap.json';
    $fieldDefinitions = json_decode(file_get_contents($fieldmapFile));
    return $fieldDefinitions;
  }

  private function getCount() {
    return trim(file_get_contents($this->getDir() . '/count.csv'));
  }

  private function getDataElementStatistics() {
    $elementsFile = $this->getDir() . '/marc-elements.csv';
    $records = [];
    $max = 0;
    if (file_exists($elementsFile)) {
      // $keys = ['element','number-of-record',number-of-instances,min,max,mean,stddev,histogram]; // "sum",
      $lineNumber = 0;
      $header = [];


      foreach (file($elementsFile) as $line) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $this->phpfyCsvHeader($values);
        } else {
          if (count($header) != count($values)) {
            error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
            error_log($line);
          }
          $record = (object)array_combine($header, $values);
          $max = max($max, $record->number_of_records);
          $record->mean = sprintf('%.2f', $record->mean);
          $record->stddev = sprintf('%.2f', $record->stddev);
          $histogram = new \stdClass();
          foreach (explode('; ', $record->histogram) as $entry) {
            list($k,$v) = explode('=', $entry);
            $histogram->$k = $v;
          }
          $record->histogram = $histogram;

          list($tag, $subfield) = explode('$', $record->path);
          if (isset($this->fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr)) {
            $record->solr = $this->fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr . '_ss';
          } else {
            if (isset($this->fieldDefinitions->fields->{$tag}->solr)) {
              $record->solr = $tag . $subfield
                . '_' . $this->fieldDefinitions->fields->{$tag}->solr
                . '_' . $subfield . '_ss';
            }
          }

          $records[] = $record;
        }
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }

    return ['records' => $records, 'max' => $max];
  }

  private function phpfyCsvHeader($header) {
    $safe_values = [];
    foreach ($header as $value) {
      if ($value == 'number-of-record') {
        $safe_values[] = 'number_of_records';
      } elseif ($value == 'number-of-instances') {
        $safe_values[] = 'number_of_instances';
      } else {
        $safe_values[] = $value;
      }
    }
    return $safe_values;
  }

  private function getPackageStatistics() {
    $elementsFile = $this->getDir() . '/packages.csv';
    $hasNonCoreTags = FALSE;
    $records = [];
    $max = 0;
    if (file_exists($elementsFile)) {
      // name,label,count
      $lineNumber = 0;
      $header = [];

      foreach (file($elementsFile) as $line) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
        } else {
          if (count($header) != count($values)) {
            error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
            error_log($line);
          }
          $record = (object)array_combine($header, $values);
          $record->percent = $record->count * 100 / $this->count;
          if ($record->label == '') {
            $record->iscoretag = false;
          }
          if (isset($record->iscoretag) && $record->iscoretag === "true") {
            $record->iscoretag = true;
          } else {
            $hasNonCoreTags = TRUE;
            $record->iscoretag = false;
          }
          $records[] = $record;
        }
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }

    return [
      'records' => $records,
      'max' => $max,
      'hasNonCoreTags' => $hasNonCoreTags
    ];
  }
}