<?php


class Nli extends Catalogue {

  protected $name = 'nli';
  protected $label = 'National Library of Israel';
  protected $url = 'https://www.nli.org.il/en';
  protected $marcVersion = 'MARC21';

  function getOpacLink($id, $record) {
    return 'https://www.nli.org.il/en/books/NNL_ALEPH' . trim($id) . '/NLI';
  }
}