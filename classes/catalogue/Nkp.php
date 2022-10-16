<?php


class Nkp extends Catalogue {

  protected $name = 'nkp';
  protected $label = 'Národní knihovna České republiky';
  protected $url = 'https://nkp.cz/';
  protected $marcVersion = 'NKCR';

  function getOpacLink($id, $record) {
    return 'https://aleph.nkp.cz/F/?func=direct'
         . '&doc_number=00' . substr(trim($id), 7)
         . '&local_base=CNB';
  }
}