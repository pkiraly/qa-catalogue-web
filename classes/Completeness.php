<?php


class Completeness extends BaseTab {

  private $hasNonCoreTags = FALSE;
  private $packages = [];
  private $packageIndex = [];
  private $records = [];
  private $types = [];
  private $type = 'all';
  private $max = 0;
  private static $supportedTypes = [
    'Books', 'Computer Files', 'Continuing Resources', 'Maps', 'Mixed Materials', 'Music', 'Visual Materials', 'all'
  ];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->type = getOrDefault('type', 'all', self::$supportedTypes);

    $this->readCount();
    $this->readPackages();
    $this->readCompleteness();

    error_log(json_encode($this->packages));
    $smarty->assign('packages', $this->packages);
    $smarty->assign('packageIndex', $this->packageIndex);
    $smarty->assign('records', $this->records);
    $smarty->assign('types', $this->types);
    $smarty->assign('selectedType', $this->type);
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

          if (isset($record->documenttype) && $record->documenttype != $this->type)
            continue;

          $record->packageid = (int) $record->packageid;
          $this->packageIndex[$record->packageid] = ($record->iscoretag == 'true' ? $record->name . ': ' . $record->label : $record->label);

          $this->max = max($this->max, $record->count);
          // $record->percent = $record->count * 100 / $this->count;
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
      usort($this->packages, function($a, $b){
        return ($a->packageid == $b->packageid)
         ? 0
         : ($a->packageid < $b->packageid)
            ? -1
            : 1;
      });
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

          if (!in_array($record->documenttype, $this->types))
            $this->types[] = $record->documenttype;

          if (isset($record->documenttype) && $record->documenttype != $this->type)
            continue;

          // $this->max = max($this->max, $record->{'number-of-record'});
          $record->mean = sprintf('%.2f', $record->mean);
          $record->stddev = sprintf('%.2f', $record->stddev);
          $histogram = new stdClass();
          foreach (explode('; ', $record->histogram) as $entry) {
            list($k,$v) = explode('=', $entry);
            $histogram->$k = $v;
          }
          $record->histogram = $histogram;
          $record->solr = $this->getSolrField($record->path);

          if ($record->package == '')
            $record->package = 'other';

          if ($record->tag == '')
            $record->tag = substr($record->path, 0, 3);
          else
            $record->tag = substr($record->path, 0, 3) . ' &mdash; ' . $record->tag;

          $record->packageid = (int) $record->packageid;
          if (!isset($this->records[$record->packageid]))
            $this->records[$record->packageid] = [];

          if (!isset($this->records[$record->packageid][$record->tag]))
            $this->records[$record->packageid][$record->tag] = [];

          $this->records[$record->packageid][$record->tag][] = $record;
        }
      }

      ksort($this->records, SORT_NUMERIC);

      $this->types = array_merge(['all'], array_diff($this->types, ['all']));
    } else {
      $msg = sprintf("file %s is not existing", $elementsFile);
      error_log($msg);
    }
  }

  private function searchFieldLink($field) {
    return sprintf('?tab=data&query=*:*&filters[]=%s:*', $field);
  }

}