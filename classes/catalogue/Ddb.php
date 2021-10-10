<?php


class Ddb extends Catalogue {

  protected $name = 'ddb';
  protected $label = 'Deutsche Digitale Bibliothek';
  protected $url = 'https://www.deutsche-digitale-bibliothek.de/';

  function getOpacLink($id, $record) {
    return 'https://www.deutsche-digitale-bibliothek.de/' . trim($id);
  }
}