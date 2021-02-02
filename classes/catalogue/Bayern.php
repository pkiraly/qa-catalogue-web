<?php


class Bayern extends Catalogue {

  protected $name = 'bayern';
  protected $label = 'Verbundkatalog B3Kat des Bibliotheksverbundes Bayern (BVB) und des Kooperativen Bibliotheksverbundes Berlin-Brandenburg (KOBV)';
  protected $url = 'https://www.bib-bvb.de/';

  function getOpacLink($id, $record) {
    return 'http://gateway-bayern.de/' . trim($id);
  }
}