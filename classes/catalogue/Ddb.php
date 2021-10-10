<?php


class Ddb extends Catalogue {

  protected $name = 'ddb';
  protected $label = 'Deutsche Digitale Bibliothek';
  protected $url = 'http://ddb.de/';

  function getOpacLink($id, $record) {
    return 'http://explore.bl.uk/BLVU1:LSCOP-ALL:BLL01' . trim($id);
  }
}