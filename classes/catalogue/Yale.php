<?php


class Yale extends Catalogue {

  protected $name = 'yale';
  protected $label = 'Yale Library';
  protected $url = 'https://library.yale.edu/';

  function getOpacLink($id, $record) {
    return 'https://search.library.yale.edu/catalog/' . $id;
  }
}