<?php


class Mek extends Catalogue {

  protected $name = 'mek';
  protected $label = 'Magyar Elektronikus Könyvtár';
  protected $url = 'https://mek.oszk.hu/';

  function getOpacLink($id, $record) {
    return 'http://mek.oszk.hu/' . trim($id);
  }
}