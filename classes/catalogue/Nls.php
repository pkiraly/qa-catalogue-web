<?php


class Nls extends Catalogue {

  protected $name = 'nls';
  protected $label = 'National Library of Scotland';
  protected $url = 'https://www.nls.uk/';

  function getOpacLink($id, $record) {
    $rid = FALSE;
    foreach ($record->getFields('015') as $tag) {
      if (isset($tag->subfields->a)) {
        $rid = str_replace('cnb', '', $tag->subfields->a);
        break;
      }
    }
    if ($rid === FALSE)
      $rid = preg_replace('/^[a-z]{1,3}\d{4}/', '00', trim($id));
    return 'https://aleph.nkp.cz/F/?func=direct'
         . '&doc_number=' . $rid
         . '&local_base=CNB';
    // https://search.nls.uk/permalink/f/19q5vbt/44NLS_ALMA21562138960004341
  }
}