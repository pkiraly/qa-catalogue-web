<?php

class Gwdg extends Catalogue {
  protected $name = 'gwdg';
  protected $label = 'GWDG';
  protected $url = 'https://www.gwdg.de/';

  function getOpacLink($id, $record) {
    $rid = FALSE;
    foreach ($record->getFields('999') as $tag) {
      if (isset($tag->subfields->c)) {
        $rid = $tag->subfields->c;
        break;
      }
    }

    if ($rid !== FALSE)
      return sprintf('https://test-mpis.koha.gwdg.de/cgi-bin/koha/opac-detail.pl?biblionumber=%s', $rid);
    else
      return null;
  }

}
