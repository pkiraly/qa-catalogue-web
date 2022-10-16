<?php


class Nkp extends Catalogue {

  protected $name = 'nkp';
  protected $label = 'Národní knihovna České republiky';
  protected $url = 'https://nkp.cz/';
  protected $marcVersion = 'NKCR';

  function getOpacLink($id, $record) {
    return 'https://aleph.nkp.cz/F/?func=direct'
         . '&doc_number=' . preg_replace('/^[a-z]{1,3}\d{4}/', '00', trim($id))
         . '&local_base=CNB';
  }
}