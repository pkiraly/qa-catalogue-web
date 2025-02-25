<?php

class Enb extends Catalogue {
  protected $name = 'enb';
  protected $label = 'Estonian National Bibliography';
  protected $url = 'https://www.rara.ee/en/';
  // protected $marcVersion = 'BL';
  // protected $linkTemplate = 'http://explore.bl.uk/BLVU1:LSCOP-ALL:BLL01{id}';

  function getOpacLink($id, $record) {
    // https://catalogue.bnf.fr/ark:/12148/cb43599300m
    return 'https://www.ester.ee/record=' . substr($id, 0, strlen($id) - 1);
  }

}
