<?php


class Loc extends Catalogue {

  protected $name = 'loc';
  protected $label = 'Library of Congress';
  protected $url = 'https://catalog.loc.gov/';

  function getOpacLink($id, $record) {
    return 'https://lccn.loc.gov/' . trim($id);
  }
}