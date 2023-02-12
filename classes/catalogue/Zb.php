<?php


class Zb extends Catalogue {

  protected $name = 'zb';
  protected $label = 'Zentralbibliothek Zürich';
  protected $url = 'https://www.zb.uzh.ch/';
  // protected $marcVersion = 'GENT';

  function getOpacLink($id, $record) {
    return 'https://uzb.swisscovery.slsp.ch/permalink/41SLSP_UZB/1d8t6qj/alma' . trim($id);
  }
}