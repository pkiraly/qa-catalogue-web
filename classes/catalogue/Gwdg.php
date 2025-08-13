<?php

class Gwdg extends Catalogue {
  protected $name = 'gwdg';
  protected $label = 'Max Planck Institutes for Intelligent Systems & Solid State Research / GWDG';
  protected $url = 'https://test-mpis.koha.gwdg.de/';

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
