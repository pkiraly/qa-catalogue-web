<?php

include_once 'Range.php';

class PicaSchemaManager {

  private $fields;
  private $tagIndex = [];

  public function __construct() {
    $this->fields = json_decode(file_get_contents('schemas/avram-k10plus.json'))->fields;
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

    if (strstr($searchTerm, '/')) {
      $parts = explode('/', $searchTerm);
      $tag = $parts[0];
      $occurence = $parts[1];
      if (isset($this->tagIndex[$tag])) {
        foreach ($this->tagIndex[$tag] as $id) {
          $candidate = $this->fields->{$id};
          if (isset($candidate->range) && $candidate->range->inRange($occurence)) {
            error_log("call in range");
            return $candidate;
          }
        }
      }
    } else {
      if (isset($this->tagIndex[$searchTerm]) && count($this->tagIndex[$searchTerm]) == 1) {
        $id = $this->tagIndex[$searchTerm][0];
        return $this->fields->{$id};
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
}