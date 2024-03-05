<?php

use Utils\SchemaType;

class SchemaUtil {

  private static bool $isSchemaInitialized = false;
  public static $schema = null;
  public static $fields = null;

  public static function initializeSchema(string $schemaType) {
    if (!self::$isSchemaInitialized) {
      self::$schemaType = $schemaType;
      if ($schemaType == SchemaType::MARC21) {
        self::initializeMarcFields();
      } elseif ($schemaType == SchemaType::PICA) {
        self::initializeSchemaManager($schemaType);
      }
      self::$isSchemaInitialized = true;
    }
  }

  public static function initializeSchemaManager(string $schemaType) {
    if (is_null(self::$schema)) {
      if ($schemaType == SchemaType::PICA)
        self::$schema = new Pica\PicaSchemaManager();
      else if ($schemaType == SchemaType::UNIMARC)
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
