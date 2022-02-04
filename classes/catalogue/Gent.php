<?php


class Gent extends Catalogue {

  protected $name = 'gent';
  protected $label = 'Universiteitsbibliotheek Gent';
  protected $url = 'https://lib.ugent.be/';
  protected $marcVersion = 'GENT';

  function getOpacLink($id, $record) {
    return 'https://lib.ugent.be/catalog/rug01:' . trim($id);
  }
}