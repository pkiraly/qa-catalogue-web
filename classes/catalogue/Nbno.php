<?php

class Nbno extends Catalogue {
  protected $name = 'nb.no';
  protected $label = 'National Library of Norway / Nasjonalbiblioteket';
  protected $url = 'https://www.nb.no/';
  # protected $marcVersion = 'KBR';
  protected $linkTemplate = 'https://www.oria.no/?vid=NB&search={id}';
}
