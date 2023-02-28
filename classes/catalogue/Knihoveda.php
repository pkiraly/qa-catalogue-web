<?php


class Knihoveda extends Catalogue {

  protected $name = 'knihoveda';
  protected $label = 'Knihoveda';
  protected $url = 'https://www.zb.uzh.ch/';
  // protected $marcVersion = 'GENT';

  function getOpacLink($id, $record) {
    return 'https://uzb.swisscovery.slsp.ch/permalink/41SLSP_UZB/1d8t6qj/alma' . trim($id);
  }
}