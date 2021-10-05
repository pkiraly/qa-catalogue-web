<?php


class Onb extends Catalogue {

  protected $name = 'onb';
  protected $label = 'Österreichische Nationalbibliothek';
  protected $url = 'https://search.onb.ac.at/primo-explore/search?vid=ONB&lang=de_DE';

  function getOpacLink($id, $record) {
    return 'http://data.onb.ac.at/rec/AC05691377' . trim($id);
  }
}