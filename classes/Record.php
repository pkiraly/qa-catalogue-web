<?php


class Record {
  private $configuration;
  private $db;
  private $doc;
  private $record;
  private $basicQueryParameters;
  private $basicFilterParameters;
  private $catalogue;

  /**
   * Record constructor.
   * @param $doc
   */
  public function __construct($doc, $configuration, $db, $catalogue) {
    $this->doc = $doc;
    $this->record = json_decode($doc->record_sni);
    $this->configuration = $configuration;
    $this->db = $db;
    $this->catalogue = $catalogue;
  }

  public function getFirstField($fieldName, $withSpaceReplace = FALSE) {
    $value = null;
    if (isset($this->doc->{$fieldName})) {
      $value = $this->doc->{$fieldName}[0];
      if ($withSpaceReplace) {
        $value = str_replace(" ", "&nbsp;", $value);
      }
    }
    return $value;
  }

  public function getField($fieldName) {
    if (isset($this->record->{$fieldName}))
      return $this->record->{$fieldName}[0];
    return null;
  }

  public function getFields($fieldName) {
    if (isset($this->record->{$fieldName}))
      return $this->record->{$fieldName};
    return null;
  }

  public function getLeaderByPosition($start, $end = NULL) {
    $leader = $this->getFirstField('Leader_ss');
    if ($leader != null) {
      $length = ($end == null) ? 1 : $end - $start;
      $part = substr($leader, $start, $length);
      if ($part == ' ') {
        $part = '" "';
      }
      return $part;
    }
    return null;
  }

  public function get008ByPosition($start, $end = NULL) {
    $field = $this->getFirstField('008_GeneralInformation_ss');
    if ($field != null) {
      $length = ($end == null) ? 1 : $end - $start;
      $part = substr($field, $start, $length);
      if ($part == ' ') {
        $part = '" "';
      }
      return $part;
    }
    return null;
  }


  public function type2icon($type) {
    switch ($type) {
      case 'Books': $icon = 'book'; break;
      case 'Maps': $icon = 'map'; break;
      case 'Computer Files': $icon = 'save'; break;
      case 'Music': $icon = 'music'; break;
      case 'Continuing Resources': $icon = 'clone'; break;
      case 'Visual Materials': $icon = 'image'; break;
      case 'Mixed Materials': $icon = 'archive'; break;
    }
    return $icon;
  }

  public function opacLink($id) {
    return $this->catalogue->getOpacLink($id, $this);
  }

  public function hasSubjectHeadings() {
    return $this->hasField(['080', '600', '610', '611', '630', '647', '648', '650', '651', '653', '655']);
  }

  public function hasAuthorityNames() {
    return $this->hasField([
      '100', '110', '111', '130',
      '700', '710', '711', '720', '730', '740', '751', '752', '753', '754',
      '800', '810', '811', '830',
    ]);
  }

  public function hasField($fields) {
    $hasField = false;
    foreach ($fields as $fieldName) {
      if (isset($this->record->{$fieldName})) {
        $hasField = true;
        break;
      }
    }
    return $hasField;
  }

  function hasSimilarBooks() {
    return (!empty($this->doc->{'9129_WorkIdentifier_ss'})
         || !empty($this->doc->{'9119_ManifestationIdentifier_ss'}));
  }

  public function getMarcFields() {
    /*
    if (is_string($doc->record_sni)) {
      $marc = json_decode($doc->record_sni);
    } else {
      $marc = json_decode($doc->record_sni[0]);
    }
    */

    $rows = [];
    foreach ($this->record as $tag => $value) {
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
    return $rows;
  }

  public function getAllSolrFields() {
    $fields = [];
    foreach ($this->doc as $label => $value) {
      if ($label == 'record_sni' || $label == '_version_') {
        continue;
      }

      $fields[] = (object)['label' => $label, 'value' => $value];
    }
    return $fields;
  }

  public function hasPublication() {
    return (!empty($this->doc->{'260a_Publication_place_ss'})
        || !empty($this->doc->{'260b_Publication_agent_ss'})
        || !empty($this->doc->{'260c_Publication_date_ss'}));
  }

  public function hasPhysicalDescription() {
    return (!empty($this->doc->{'300a_PhysicalDescription_extent_ss'})
        || !empty($this->doc->{'300c_PhysicalDescription_dimensions_ss'}));
  }

  public function hasMainPersonalName() {
    return (!empty($this->doc->{'100a_MainPersonalName_personalName_ss'})
        || !empty($this->doc->{'100d_MainPersonalName_dates_ss'}));
  }

  public function formatMarcDate($date) {
    $y = substr($date, 0, 2);
    $m = substr($date, 2, 2);
    $d = substr($date, 4);
    $y = preg_match('/^[01]/', $y) ? '20' . $y : '19' . $y;
    $date = sprintf("%s-%s-%s", $y, $m, $d);
    return $date;
  }

  public function setBasicQueryParameters(array $basicQueryParameters) {
    $this->basicQueryParameters = $basicQueryParameters;
  }

  public function setBasicFilterParameters(array $basicFilterParameters) {
    $this->basicFilterParameters = $basicFilterParameters;
  }

  public function link($field, $value) {
    $query = 'query=' . urlencode(sprintf('%s:"%s"', $field, $value));
    return '?' . join('&', array_merge([$query], $this->basicQueryParameters));
  }

  public function filter($field, $value) {
    $filter = 'filters[]=' . urlencode(sprintf('%s:"%s"', $field, $value));
    return '?' . join('&', array_merge([$filter], $this->basicFilterParameters));
  }

  public function getDoc() {
    return $this->doc;
  }
}