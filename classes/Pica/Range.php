<?php

namespace Pica;

class Range {

  private $raw;
  private $start;
  private $end;
  private $unitLength = 0;
  private $hasRange;

  public function __construct($raw) {
    $this->raw = $raw;
    if (!is_null($this->raw))
      $this->parse();
  }

  private function parse() {
    $parts = explode("-", $this->raw);
    $this->hasRange = count($parts) == 2;
    $this->start = $parts[0];
    if ($this->hasRange)
      $this->end = $parts[1];
    $this->unitLength = strlen($this->start);
  }

  public function inRange($occurence) {
    if (!$this->isNull()) {
      if ($this->getUnitLength() == strlen($occurence)) {
        if ($this->hasRange) {
          if (strcmp($this->start, $occurence) > 0 || strcmp($this->end, $occurence) < 0)
            return false;
          return true;
        } else {
          return $this->start == $occurence;
        }
      }
    }
    return false;
  }

  public function getRaw() {
    return $this->raw;
  }

  public function getStart() {
    return $this->start;
  }

  public function getEnd() {
    return $this->end;
  }

  public function getUnitLength(): int {
    return $this->unitLength;
  }

  public function getHasRange() {
    return $this->hasRange;
  }

  public function isNull() {
    return is_null($this->raw);
  }
}
