<?php


class K10plus_pica extends Catalogue {

  protected $name = 'k10plus_pica';
  protected $label = 'K10plus-Verbundkatalog (PICA)';
  protected $url = 'https://opac.k10plus.de';

  function getOpacLink($id, $record) {
    return ' https://opac.k10plus.de/DB=2.299/PPNSET?PPN=' . trim($id) . '&PRS=HOL&HILN=888&INDEXSET=21';
  }
}
