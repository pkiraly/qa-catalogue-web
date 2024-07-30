<?php


class Ogyk extends Catalogue {

  protected $name = 'ogyk';
  protected $label = 'Országgyűlési Könyvtár katalógusa';
  protected $url = 'https://opacplus.ogyk.hu/';
  protected $marcVersion = 'OGYK';

  function getOpacLink($id, $record) {
//    return 'http://opacplus.ogyk.hu/permalink/f/h9en5r/' . trim($id);
    $rid = preg_replace('/^OGYK/', '', trim($id));
    return 'https://opac.ogyk.hu/F/?func=direct'
         . '&doc_number=' . $rid
         . '&local_base=OGY01&format=001';
  }
}