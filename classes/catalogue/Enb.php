<?php

class Enb extends Catalogue {
  protected $name = 'enb';
  protected $label = 'Estonian National Bibliography';
  protected $url = 'https://www.rara.ee/en/';

  function getOpacLink($id, $record) {
    return 'https://www.ester.ee/record=' . substr($id, 0, strlen($id) - 1);
  }

}
