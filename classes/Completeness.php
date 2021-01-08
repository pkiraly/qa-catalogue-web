<?php


class Completeness extends BaseTab {

  private $hasNonCoreTags = FALSE;
  private $packages = [];
  private $records = [];
  private $max = 0;

  public function prepareData(&$smarty) {
    $this->readCount();
    $this->readPackages();
    $this->readCompleteness();

    $smarty->assign('db', $this->db);
    $smarty->assign('packages', $this->packages);
    $smarty->assign('records', $this->records);
    $smarty->assign('max', $this->max);
    $smarty->assign('hasNonCoreTags', $this->hasNonCoreTags);
  }

  public function getTemplate() {
    return 'completeness.tpl';
  }

  private function readPackages() {
    $elementsFile = $this->getFilePath('packages.csv');

    if (file_exists($elementsFile)) {
      // name,label,count
      $lineNumber = 0;
      $header = [];

      $fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

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
            $this->hasNonCoreTags = TRUE;
            $record->iscoretag = false;
          }
          $this->packages[] = $record;
        }
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
  }

  private function readCompleteness() {
    $elementsFile = $this->getFilePath('marc-elements.csv');
    if (file_exists($elementsFile)) {
      // $keys = ['element','number-of-record',number-of-instances,min,max,mean,stddev,histogram]; // "sum",
      $lineNumber = 0;
      $header = [];

      $fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

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
          if (isset($record->type) && $record->type != 'all')
            continue;

          $this->max = max($this->max, $record->{'number-of-record'});
          $record->mean = sprintf('%.2f', $record->mean);
          $record->stddev = sprintf('%.2f', $record->stddev);
          $histogram = new stdClass();
          foreach (explode('; ', $record->histogram) as $entry) {
            list($k,$v) = explode('=', $entry);
            $histogram->$k = $v;
          }
          $record->histogram = $histogram;
          $record->solr = $this->getSolrField($record->path);

          /*
          list($tag, $subfield) = explode('$', $record->path);
          if (isset($fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr)) {
            $record->solr = $fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr . '_ss';
          } else {
            if (isset($fieldDefinitions->fields->{$tag}->solr)) {
              $record->solr = $tag . $subfield
                  . '_' . $fieldDefinitions->fields->{$tag}->solr
                  . '_' . $subfield . '_ss';
            }
          }
          */

          $this->records[] = $record;
        }
      }
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
  }

  private function searchFieldLink($field) {
    return sprintf('?tab=data&query=*:*&filters[]=%s:*', $field);
  }

}