<?php


class Harvard extends Catalogue {

  protected $name = 'harvard';
  protected $label = 'Harvard Library';
  protected $url = 'https://library.harvard.edu/';

  function getOpacLink($id, $record) {
    return ' http://id.lib.harvard.edu/alma/' . trim($id) . '/catalog';
  }
}