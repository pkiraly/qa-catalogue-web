<?php


class Szte extends Catalogue {

  protected $name = 'szte';
  protected $label = 'A Szegedi Tudományegyetem Klebelsberg Kuno Könyvtára';
  protected $url = 'http://www.ek.szte.hu/';

  function getOpacLink($id, $record) {
    return 'http://qulto.bibl.u-szeged.hu/record/-/record/' . trim($id);
  }
}