<?php


namespace App\Entity;


class Field
{
  private $fieldName;
  private $field;

  function __construct($fieldName, $field) {
    $this->fieldName = $fieldName;
    $this->field = $field;
  }

  public function getSubfields() {
    return $this->field->subfields;
  }

  public function hasAnySubfieldsOf($subfields) {
    $hasIt = FALSE;
    foreach ($subfields as $subfield) {
      if ($this->hasSubfield($subfield)) {
        $hasIt = TRUE;
        break;
      }
    }
    return $hasIt;
  }

  public function has($subfield) {
    return $this->hasSubfield($subfield);
  }

  public function hasSubfield($subfield) {
    return isset($this->field->subfields->{$subfield});
  }

  public function get($subfield) {
    return $this->getSubfield($subfield);
  }

  public function getSubfield($subfield) {
    if ($this->hasSubfield($subfield))
      return $this->field->subfields->{$subfield};
    return null;
  }

  public function getQuery($subfield) {
    return sprintf('%s:"%s"', $this->getSolrField($subfield), $this->get('a'));
  }

  /**
   * @param $subfield
   * @return string|null
   */
  public function getSolrField($subfield) {
    return SolrFieldMapping::getSolrField($this->fieldName . $subfield);
  }
}