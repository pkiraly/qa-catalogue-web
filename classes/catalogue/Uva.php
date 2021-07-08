<?php


class Uva extends Catalogue {

  protected $name = 'uva';
  protected $label = 'Bibliotheek Universiteit van Amsterdam/Hogeschool van Amsterdam';
  protected $url = 'https://uba.uva.nl/home';

  function getOpacLink($id, $record) {
    return ' https://pid.uba.uva.nl/ark:/88238/b1' . trim($id);
  }
}