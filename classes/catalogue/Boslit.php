<?php

class Boslit extends Catalogue {
  protected $name = 'boslit';
  protected $label = 'BOSLIT (Bibliography of Scottish Literature in Translation)';
  protected $url = 'https://www.rara.ee/en/';

  function getOpacLink($id, $record) {
    return 'https://www.ester.ee/record=' . substr($id, 0, strlen($id) - 1);
  }

}
