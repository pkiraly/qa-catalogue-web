<?php


class Mokka extends Catalogue {

  protected $name = 'mokka';
  protected $label = 'Magyar Országos Közös Katalógus';
  protected $url = 'http://mokka.hu/';

  function getOpacLink($id, $record) {
    return 'http://mokka.hu/web/guest/record/-/record/' . trim($id);
  }
}