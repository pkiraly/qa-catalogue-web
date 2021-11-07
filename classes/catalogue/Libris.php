<?php


class Libris extends Catalogue {

  protected $name = 'libris';
  protected $label = 'Libris, the Swedish national union catalogue';
  protected $url = 'https://libris.kb.se/';

  function getOpacLink($id, $record) {
    return 'http://libris.kb.se/' . trim($id);
  }
}