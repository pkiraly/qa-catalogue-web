<?php

namespace Schema;

abstract class SchemaManager {
  protected $fields;
  protected $tagIndex = [];
  protected $schemaFile;
  protected bool $supportRange;

  /**
   * @return void
   */
  protected function extractFields(): void {
    $this->fields = json_decode(file_get_contents($this->schemaFile))->fields;
    foreach ($this->fields as $id => $field) {
      if ($this->supportRange)
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

    if ($this->supportRange && $this->hasOccurrence($searchTerm)) {
      $parts = explode('/', $searchTerm);
      $tag = $parts[0];
      $occurrence = $parts[1];
      if (isset($this->tagIndex[$tag])) {
        foreach ($this->tagIndex[$tag] as $id) {
          $candidate = $this->fields->{$id};
          if (isset($candidate->range) && $candidate->range->inRange($occurrence))
            return $candidate;
        }
      }
    } else {
      if (isset($this->tagIndex[$searchTerm]) && count($this->tagIndex[$searchTerm]) == 1) {
        $id = $this->tagIndex[$searchTerm][0];
        return $this->fields->{$id};
      } else {
        if ($this->supportRange)
          return $this->lookup($searchTerm . '/00');
      }
    }
    return false;
  }

  /**
   * @param $searchTerm
   * @return false|string
   */
  protected function hasOccurrence($searchTerm) {
    return strstr($searchTerm, '/');
  }

  protected function createRange($field): void {
    if (isset($field->occurrence))
      $field->range = new Range($field->occurrence);
    elseif (isset($field->counter))
      $field->range = new Range($field->counter);
    else
      $field->range = null;
  }
}