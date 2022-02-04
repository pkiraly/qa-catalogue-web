<?php


abstract class Catalogue {

  protected $name;
  protected $label;
  protected $url;
  protected $marcVersion = 'MARC21';

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

  public function getMarcVersion() {
    return $this->marcVersion;
  }
}