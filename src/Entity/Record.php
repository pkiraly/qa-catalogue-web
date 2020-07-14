<?php


namespace App\Entity;


class Record
{
  private $solr;
  private $marc;

  function __construct($doc) {
    $this->solr = $doc;
    $this->marc = json_decode($doc->record_sni);
  }

  public function getId() {
    return trim($this->solr->id);
  }

  public function getType() {
    return trim($this->solr->type_ss[0]);
  }

  public function has($fieldName) {
    return $this->hasField($fieldName);
  }

  public function hasField($fieldName) {
    return isset($this->marc->{$fieldName});
  }

  public function get($fieldName) {
    return $this->getField($fieldName);
  }

  public function getField($fieldName) {
    $fields = [];
    if ($this->hasField($fieldName))
      foreach ($this->marc->{$fieldName} as $field)
        $fields[] = new Field($fieldName, $field);
    return $fields;
  }

  public function getFirstField($fieldName) {
    $value = $this->getField($fieldName);
    if (!empty($value)) {
      $value = $value[0];
    }
    return $value;
  }

  public function getSubfield($fieldName, $subfield) {
    if ($this->hasField($fieldName)) {
      foreach ($this->getFirstField($fieldName) as $field) {
        if ($field->hasSubfield($subfield))
          return $field->getSubfield($subfield);
      }
    }
    return null;
  }

  public function getSolrField($fieldName) {
    if (isset($this->solr->{$fieldName}))
      return $this->solr->{$fieldName};
  }

  function hasSubfield($field, $subfield) {
    return isset($field->subfields->{$subfield});
  }

  function hasAuthorityNames() {
    return $this->hasAnyFieldOf([
      '100', '110', '111', '130',
      '700', '710', '711', '720', '730', '740', '751', '752', '753', '754',
      '800', '810', '811', '830',
    ]);
  }

  function hasSubjectHeadings() {
    return $this->hasAnyFieldOf([
      '080', '600', '610', '611', '630', '647', '648', '650', '651', '653', '655'
    ]);
  }

  // MainPersonalName [personalName, dates]
  function hasMainPersonalName() {
    return $this->hasAnySubfieldsOf('100', ['a', 'd']);
  }

  function hasPublication() {
    return $this->hasAnySubfieldsOf('260', ['a', 'b', 'c']);
  }

  function hasPhysicalDescription() {
    // PhysicalDescription [extent, dimensions]
    return $this->hasAnySubfieldsOf('300', ['a', 'c']);
  }

  // 9129_WorkIdentifier_ss, 9119_ManifestationIdentifier_ss
  function hasSimilarBooks() {
    return $this->hasAnySubfieldsOf('911', ['9'])
        || $this->hasAnySubfieldsOf('912', ['9']);
  }

  public function hasAnySubfieldsOf($fieldName, $subfields) {
    $hasIt = FALSE;
    if ($this->hasField($fieldName)) {
      foreach ($this->getField($fieldName) as $i => $field) {
        foreach ($subfields as $subfield) {
          if ($field->hasSubfield($subfield)) {
            $hasIt = TRUE;
            break;
          }
        }
      }
    }
    return $hasIt;
  }

  function hasAnyFieldOf($fields) {
    $hasAny = false;
    foreach ($fields as $fieldName) {
      if (isset($this->marc->{$fieldName})) {
        $hasAny = true;
        break;
      }
    }
    return $hasAny;
  }

  function getAllSolrFields() {
    $fields = [];
    foreach ($this->solr as $label => $value) {
      if ($label == 'record_sni' || $label == '_version_')
        continue;

      $fields[] = (object)[
        'label' => $label,
        'value' => $value
      ];
    }
    return $fields;
  }

  function getMarcFields() {
    $rows = [];
    $tags = [];
    foreach ($this->marc as $tag => $value) {
      $tags[] = $tag;
      if (preg_match('/^00/', $tag)) {
        $rows[] = [$tag, '', '', '', $value];
      } else if ($tag == 'leader') {
        $rows[] = ['LDR', '', '', '', $value];
      } else {
        foreach ($value as $instance) {
          $firstRow = [$tag, $instance->ind1, $instance->ind2];
          $i = 0;
          foreach ($instance->subfields as $code => $s_value) {
            $i++;
            if ($i == 1) {
              $firstRow[] = '$' . $code;
              $firstRow[] = $s_value;
              $rows[] = $firstRow;
            } else {
              $rows[] = ['', '', '', '$' . $code, $s_value];
            }
          }
        }
      }
    }
    error_log('tags: ' . join(', ', $tags));
    return $rows;
  }

}