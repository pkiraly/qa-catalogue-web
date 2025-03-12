<?php

class Elb extends Catalogue {
  protected $name = 'elb';
  protected $label = 'European Literary Bibliography';
  protected $url = 'https://literarybiliography.eu/';

  function getOpacLink($id, $record) {
    return 'https://literarybiliography.eu/record=' . $id;
  }

}
