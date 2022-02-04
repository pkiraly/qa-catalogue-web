<?php


class Kbr extends Catalogue {

  protected $name = 'kbr';
  protected $label = 'KBR (Koninklijke Bibliotheek van België/Bibliothèque royale de Belgique)';
  protected $url = 'https://www.kbr.be/';
  protected $marcVersion = 'KBR';

  function getOpacLink($id, $record) {
    return 'https://opac.kbr.be/LIBRARY/doc/SYRACUSE/' . trim($id);
  }
}
