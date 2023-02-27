<?php


class Kb extends Catalogue {

  protected $name = 'kb';
  protected $label = 'KB (Koninklijke Bibliotheek van Nederland)';
  protected $url = 'https://www.kb.nl/';
  // protected $marcVersion = 'KBR';

  function getOpacLink($id, $record) {
    return 'https://webggc.oclc.org/cbs/DB=2.37/XMLPRS=Y/PPN?PPN=' . trim($id);
  }
}
