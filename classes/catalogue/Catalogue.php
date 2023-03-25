<?php


abstract class Catalogue {

  protected $name;
  protected $label;
  protected $url;
  protected $schemaType = 'MARC21';
  protected $marcVersion = 'MARC21';
  protected $position = 3;
  public static $supportedTypes = [
    'Books', 'Computer Files', 'Continuing Resources', 'Maps', 'Mixed Materials', 'Music', 'Visual Materials', 'all'
  ];
  protected $defaultLang = 'en';
  protected $metadataSchema = 'MARC21 scheme';

  abstract function getOpacLink($id, $record);

  public function getName() {
    return $this->name;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getUrl() {
    return $this->url;
  }

  /**
   * @return string
   */
  public function getSchemaType(): string {
    return $this->schemaType;
  }


  public function getMarcVersion() {
    return $this->marcVersion;
  }

  /**
   * @return int
   */
  public function getPosition(): int {
    return $this->position;
  }

  public function getTag(string $input): string {
    return substr($input, 0, 3);
  }

  public function getSubfield($input): string {
    if (is_null($input))
      return "";
    return substr($input, 3);
  }

  /**
   * @return string
   */
  public function getDefaultLang(): string {
    return $this->defaultLang;
  }

  /**
   * @return string
   */
  public function getMetadataSchema(): string {
    return $this->metadataSchema;
  }
}