<?php


class Nkp extends Catalogue {

  protected $name = 'nkp';
  protected $label = 'Česká literární bibliografie';
  protected $url = 'https://clb.ucl.cas.cz/';
  protected $marcVersion = 'NKCR';

  function getOpacLink($id, $record) {
    return 'https://vufind.ucl.cas.cz/Record/' . trim($id);
  }
}