<?php


class Bnf extends Catalogue {

  protected $name = 'bnf';
  protected $label = 'Bibliothèque nationale de France (French National Library)';
  protected $url = 'https://www.bnf.fr/fr';
  protected $schemaType = "UNIMARC";

  function getOpacLink($id, $record) {
    // https://catalogue.bnf.fr/ark:/12148/cb43599300m
    return $record->getField('003');
  }
}

