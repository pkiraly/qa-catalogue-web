<?php


class Onb extends Catalogue {

  protected $name = 'onb';
  protected $label = 'Österreichische Nationalbibliothek';
  protected $url = 'https://search.onb.ac.at/primo-explore/search?vid=ONB&lang=de_DE';

  function getOpacLink($id, $record) {
    error_log(json_encode($record));
    foreach ($record->getDoc()->{'035a_SystemControlNumber_ss'} as $tag35a) {
      if (preg_match('/\(AT-OBV\)/', $tag35a)) {
        $id = preg_replace('/\(AT-OBV\)/', '', $tag35a);
        break;
      }
    }
    return 'http://data.onb.ac.at/rec/' . trim($id);
  }
}