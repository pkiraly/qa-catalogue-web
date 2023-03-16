<?php

include_once 'Range.php';
include_once __DIR__ . '/../catalogue/Catalogue.php';

class PicaSchemaManager {

  private $fields;
  private $tagIndex = [];

  public function __construct() {
    global $tab;
    $catalogue = $tab->getCatalogue();
    $schemaType = $catalogue->getSchemaType();

    // $schemaFile = 'schemas/avram-k10plus.json';
    $schemaFile = 'schemas/avram-k10plus-title.json';
    $this->fields = json_decode(file_get_contents($schemaFile))->fields;
    foreach ($this->fields as $id => $field) {
      $this->createRange($field);

      if (!isset($this->tagIndex[$field->tag])) {
        $this->tagIndex[$field->tag] = [];
      }
      $this->tagIndex[$field->tag][] = $id;
    }
  }

  public function lookup($searchTerm) {
    if (isset($this->fields->{$searchTerm}))
      return $this->fields->{$searchTerm};

    if ($this->hasOccurrence($searchTerm)) {
      $parts = explode('/', $searchTerm);
      $tag = $parts[0];
      $occurence = $parts[1];
      if (isset($this->tagIndex[$tag])) {
        foreach ($this->tagIndex[$tag] as $id) {
          $candidate = $this->fields->{$id};
          if (isset($candidate->range) && $candidate->range->inRange($occurence))
            return $candidate;
        }
      }
    } else {
      if (isset($this->tagIndex[$searchTerm]) && count($this->tagIndex[$searchTerm]) == 1) {
        $id = $this->tagIndex[$searchTerm][0];
        return $this->fields->{$id};
      } else {
        return $this->lookup($searchTerm . '/00');
      }
    }
    return false;
  }

  private function createRange($field): void {
    if (isset($field->occurrence))
      $field->range = new Range($field->occurrence);
    elseif (isset($field->counter))
      $field->range = new Range($field->counter);
    else
      $field->range = null;
  }

  /**
   * @param $searchTerm
   * @return false|string
   */
  private function hasOccurrence($searchTerm) {
    return strstr($searchTerm, '/');
  }
}