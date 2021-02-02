<?php


class Gbv extends Catalogue {

  protected $name = 'gbv';
  protected $label = 'Verbundzentrale des Gemeinsamen Bibliotheksverbundes';
  protected $url = 'http://www.gbv.de/';

  function getOpacLink($id, $record) {
    return sprintf('https://kxp.k10plus.de/DB=2.1/PPNSET?PPN=%s', trim($id));
  }
}