<?php


class K10plus extends Catalogue {

  protected $name = 'K10plus';
  protected $label = 'K10plus-Verbundkatalog';
  protected $url = 'https://opac.k10plus.de';

  function getOpacLink($id, $record) {
    return 'https://opac.k10plus.de/DB=2.299/PPNSET?PPN=' . trim($id) . '&PRS=HOL&HILN=888&INDEXSET=21';
  }
}
