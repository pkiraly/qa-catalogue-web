<?php


class Dnb extends Catalogue {

  protected $name = 'dnb';
  protected $label = 'Deutsche Nationalbibliothek';
  protected $url = 'https://www.dnb.de/';
  protected $marcVersion = 'DNB';

  function getOpacLink($id, $record) {
    return 'http://d-nb.info/' . trim($id);
  }
}