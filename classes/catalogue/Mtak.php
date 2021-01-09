<?php


class Mtak extends Catalogue {

  protected $name = 'mtak';
  protected $label = 'Magyar Tudományos Akadémia Könyvtára';
  protected $url = 'https://mtak.hu/';

  function getOpacLink($id, $record) {
    return 'https://mta-primotc.hosted.exlibrisgroup.com/permalink/f/1s1uct8/36MTA' . trim($id);
  }
}