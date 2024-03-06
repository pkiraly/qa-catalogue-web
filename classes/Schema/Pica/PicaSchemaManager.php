<?php

namespace Schema\Pica;

use Schema\SchemaManager;

class PicaSchemaManager extends SchemaManager {

  public function __construct() {
    global $tab;
    $catalogue = $tab->getCatalogue();
    $schemaType = $catalogue->getSchemaType();
    $this->supportRange = true;

    // $schemaFile = 'schemas/avram-k10plus.json';
    $schemaFile = 'schemas/avram-k10plus-title.json';
    $this->extractFields();
  }
}
