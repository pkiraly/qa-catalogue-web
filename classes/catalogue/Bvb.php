<?php


class Bvb extends Catalogue {

  protected $name = 'bvb';
  protected $label = 'BibliotheksVerbund Bayern';
  protected $url = 'http://www.bib-bvb.de/';

  function getOpacLink($id, $record) {
    return 'http://explore.bl.uk/BLVU1:LSCOP-ALL:BLL01' . trim($id);
  }
}