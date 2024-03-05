<?php

use Utils\SchemaType;

class SchemaUtil {

  private static bool $isSchemaInitialized = false;
  public static $schema = null;
  public static $fields = null;
  private static SchemaType $schemaType;

  public static function initializeSchema(string $_schemaType) {
    $schemaType = SchemaType::tryFrom($_schemaType) ?? SchemaType::MARC21;
    if (!self::$isSchemaInitialized) {
      self::$schemaType = $schemaType;
      if ($schemaType == 'MARC21') {
        self::initializeMarcFields();
      } elseif ($schemaType == 'PICA') {
        self::initializeSchemaManager($schemaType);
      }
      self::$isSchemaInitialized = true;
    }
  }

  public static function initializeSchemaManager(SchemaType $schemaType) {
    if (is_null(self::$schema)) {
      if ($schemaType == 'PICA')
        self::$schema = new Pica\PicaSchemaManager();
      else if ($schemaType == 'UNIMARC')
        self::$schema = new Unimarc\UnimarcSchemaManager();
    }
  }

  public static function initializeMarcFields() {
    if (is_null(self::$fields)) {
      self::$fields = json_decode(file_get_contents('schemas/marc-schema-with-solr-and-extensions.json'))->fields;
    }
  }

  public static function getDefinition($tag) {
    if (self::$schemaType == 'MARC21') {
      if (isset(self::$fields->{$tag}))
        return self::$fields->{$tag};
    } else if (self::$schemaType == 'PICA') {
      return self::$schema->lookup($tag);
    }
    return null;
  }
}
