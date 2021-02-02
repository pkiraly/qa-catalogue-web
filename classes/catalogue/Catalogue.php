<?php


abstract class Catalogue {

  protected $name;
  protected $label;
  protected $url;

  abstract function getOpacLink($id, $record);

  public function getName() {
    return $this->name;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getUrl() {
    return $this->url;
  }
}