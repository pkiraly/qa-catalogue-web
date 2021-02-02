<?php


class Bl extends Catalogue {

  protected $name = 'bl';
  protected $label = 'British Library';
  protected $url = 'http://bl.uk/';

  function getOpacLink($id, $record) {
    return 'http://explore.bl.uk/BLVU1:LSCOP-ALL:BLL01' . trim($id);
  }
}