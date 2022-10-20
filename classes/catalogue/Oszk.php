<?php


class Oszk extends Catalogue {

  protected $name = 'oszk';
  protected $label = 'Orszägos Széchényi Könyvtár';
  protected $url = 'https://www.oszk.hu/';
  // protected $marcVersion = 'B3KAT';

  function getOpacLink($id, $record) {
    return 'http://gateway-bayern.de/' . trim($id);
  }
}