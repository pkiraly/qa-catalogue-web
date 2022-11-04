<?php


class Lnb extends Catalogue {

  protected $name = 'lnb';
  protected $label = 'Latvijas Nacionālā bibliotēka';
  protected $url = 'https://lnb.lv/';

  function getOpacLink($id, $record) {
    return 'https://pid.uba.uva.nl/ark:/88238/b1' . trim($id);
  }
}
