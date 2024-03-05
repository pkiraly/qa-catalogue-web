<?php


class Bnpt extends Catalogue {

  protected $name = 'bnpt';
  protected $label = 'Biblioteca Nacional de Portugal (Portugal National Library)';
  protected $url = 'https://www.bnportugal.gov.pt/';

  function getOpacLink($id, $record) {
    foreach ($record->getDoc()->{'035a_SystemControlNumber_ss'} as $tag35a) {
      if (preg_match('/^\d/', $tag35a)) {
        $identifier = $tag35a;
        break;
      }
    }
    return sprintf('http://id.bnportugal.gov.pt/bib/catbnp/%s', trim($identifier));
  }
}

