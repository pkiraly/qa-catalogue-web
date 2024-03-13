<?php

namespace Schema\Unimarc;

use Schema\SchemaManager;

class UnimarcSchemaManager extends SchemaManager {

  public function __construct() {
    global $tab;
    $catalogue = $tab->getCatalogue();
    $schemaType = $catalogue->getSchemaType();
    $this->supportRange = false;

    $this->schemaFile = 'schemas/avram-unimarc.json';
    $this->extractFields();
  }
}
