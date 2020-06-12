<?php


namespace App\Controller;


class BaseContextualController extends BaseController
{

  /**
   * Reads marc-elements.csv file
   * @return object
   */
  protected function readElements() {
    $data = [];
    $elementsFile = $this->getDir() . '/marc-elements.csv';
    if (file_exists($elementsFile)) {
      $header = [];
      $elements = [];
      $in = fopen($elementsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $elements[$record->path] = $record->subfield;
        }
      }
      $data['hasElements'] = TRUE;
      $data['elements'] = $elements;
    } else {
      $data['hasElements'] = FALSE;
    }

    return $data;
  }

}