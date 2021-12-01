<?php


class Kbr extends Catalogue {

  protected $name = 'kbr';
  protected $label = 'KBR';
  protected $url = 'https://uba.uva.nl/home';

  function getOpacLink($id, $record) {
    return ' https://pid.uba.uva.nl/ark:/88238/b1' . trim($id);
  }
}
