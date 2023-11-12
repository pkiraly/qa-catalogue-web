<?php


class Record {
  private $configuration;
  private $db;
  private $doc;
  private $record;
  private $basicQueryParameters;
  private $basicFilterParameters;
  private $catalogue;
  private static bool $isSchemaInitialized = false;
  private static $schema = null;
  private static $fields = null;

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
      return is_array($this->record->{$fieldName}) ? $this->record->{$fieldName}[0] : $this->record->{$fieldName};
    return null;
  }

  public function getFields($fieldName) {
    if (isset($this->record->{$fieldName}))
      return $this->record->{$fieldName};
    return null;
  }

  public function getAllSubfields($fieldName, $subfieldName): array {
    $subfields = [];
    if (isset($this->record->{$fieldName})) {
      $fields = $this->record->{$fieldName};
      if (!is_array($fields))
        $fields = [$fields];
      foreach ($fields as $field) {
        if (property_exists($field->subfields, $subfieldName)) {
          if (is_array($field->subfields->{$subfieldName}))
            $subfields = array_merge($subfields, $field->subfields->{$subfieldName});
          else
            $subfields[] = $field->subfields->{$subfieldName};
        }
      }
    }
    return $subfields;
  }

  public function resolveLeader($definition, $code) {
    if ($code == '" "')
      $code = ' ';
    if (isset($definition->codes)) {
      if (isset($definition->codes->{$code})) {
        return $definition->codes->{$code}->label;
      } else {
        return 'invalid value';
      }
    }
    return '';
  }

  public function resolve008($definition, $code) {
    if ($code == '')
      return 'missing value';
    if ($code == '" "')
      $code = ' ';
    if (isset($definition->codes)) {
      if ($definition->repeatableContent === TRUE) {
        $resoltutions = [];
        for ($i = 0; $i < strlen($code); $i += $definition->unitLength) {
          $unit = substr($code, $i, $definition->unitLength);
          if (isset($definition->codes->{$unit})) {
            $value = $definition->codes->{$unit}->label;
          } else {
            $value = 'invalid value';
          }
          if (!in_array($value, $resoltutions))
            $resoltutions[] = $value;
        }
        return implode(' - ', $resoltutions);
      } else {
        if (isset($definition->codes->{$code})) {
          return $definition->codes->{$code}->label;
        } else {
          return 'invalid value';
        }
      }
    }
    return '';
  }

  public function getLeaderByPositionString($position) {
    $atomic = explode('-', $position, 2);
    array_walk($atomic, function(&$value, $key) {
      $value = (int) preg_replace('/^0+/', '', $value);
    });
    if (count($atomic) == 2)
      return $this->getLeaderByPosition($atomic[0], $atomic[1]);
    else
      return $this->getLeaderByPosition($atomic[0]);
  }

  public function getLeaderByPosition($start, $end = NULL) {
    $leader = $this->getFirstField('Leader_ss');
    if ($leader != null) {
      $length = ($end == null) ? 1 : $end - $start;
      $part = substr($leader, $start, $length);
      return $part;
    }
    return null;
  }

  public function get008ByPosition($start, $end = NULL) {
    $field = $this->getField('008');
    if ($field != null) {
      $length = ($end == null) ? 1 : $end - $start;
      $part = substr($field, $start, $length);
      return $part;
    }
    return null;
  }

  public function get007ByPosition($start, $end = NULL) {
    $field = $this->getField('007');
    if ($field != null) {
      $length = ($end == null) ? 1 : $end - $start;
      $part = substr($field, $start, $length);
      return $part;
    }
    return null;
  }

  public function get006ByPosition($start, $end = NULL) {
    $field = $this->getField('006');
    if ($field != null) {
      $length = ($end == null) ? 1 : $end - $start;
      $part = substr($field, $start, $length);
      return $part;
    }
    return null;
  }

  public function type2icon($type) {
    switch ($type) {
      case 'Books':
      case 'Druckschriften (einschließlich Bildbänden)':
        $icon = 'book'; break;
      case 'Maps': $icon = 'map'; break;
      case 'Computer Files': $icon = 'save'; break;
      case 'Music': $icon = 'music'; break;
      case 'Continuing Resources': $icon = 'clone'; break;
      case 'Visual Materials': $icon = 'image'; break;
      case 'Mixed Materials':
      case 'Medienkombination':
      case 'Tonträger, Videodatenträger, Bildliche Darstellungen':
        $icon = 'archive'; break;
      default:
        $icon = 'book'; break;
    }
    return $icon;
  }

  public function opacLink($id) {
    return $this->catalogue->getOpacLink($id, $this);
  }

  public function issueLink($id) {
    return '?' . join('&', [
      'tab=record-issues',
      // 'action=record',
      'recordId=' . $id,
      'ajax=1'
    ]);
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

  public function getMarcFields($schemaType = 'MARC21'): array {
    self::initializeSchema($schemaType);

    $rows = [];
    foreach ($this->record as $tag => $value) {
      if ($tag == 'leader')
        $tag = 'LDR';
      $tag_defined = isset(self::$fields->{$tag});
      $definition = $tag_defined ? self::$fields->{$tag} : null;
      $tagToDisplay = $schemaType == 'PICA' ? $this->picaTagLink($tag, false) : $this->marcTagLink($tag, $definition);
      if ($schemaType == 'MARC21' && preg_match('/^00/', $tag)) {
        $rows[] = [$tagToDisplay, '', '', '', $value];
      } else if ($tag == 'LDR') {
        $rows[] = [$tagToDisplay, '', '', '', $value];
      } else {
        if (!is_null($value) && is_array($value) && !empty($value)) {
          foreach ($value as $instance) {
            if ($schemaType != 'PICA')
              $firstRow = [$tagToDisplay, $instance->ind1, $instance->ind2];
            else
              $firstRow = [$tagToDisplay, '', ''];
            $i = 0;
            foreach ($instance->subfields as $code => $s_value) {
              $i++;
              if ($i == 1 && is_string($s_value)) {
                $firstRow[] = '$' . $code;
                $firstRow[] = htmlentities($s_value);
                $rows[] = $firstRow;
              } else {
                if (is_string($s_value))
                  $rows[] = ['', '', '', '$' . $code, htmlentities($s_value)];
                else if (is_array($s_value)) {
                  foreach ($s_value as $v)
                    $rows[] = ['', '', '', '$' . $code, htmlentities($v)];
                }
              }
            }
          }
        }
      }
    }
    return $rows;
  }

  public function resolveMarcFields($schemaType = 'MARC21'): array {
    self::initializeSchema($schemaType);

    $rows = [];
    foreach ($this->record as $tag => $value) {
      if ($tag == 'leader')
        $tag = 'LDR';
      $tag_defined = isset(self::$fields->{$tag});
      $definition = $tag_defined ? self::$fields->{$tag} : null;
      $tagToDisplay = $schemaType == 'PICA' ? $this->picaTagLink($tag) : $this->marcTagLink($tag, $definition);

      if ($tag_defined && !isset($definition->label))
        error_log('no tag label for ' . $tag);
      $tagLabel = $tag_defined && isset($definition->label) ? $definition->label : '';
      if ($schemaType == 'MARC21' && preg_match('/^00/', $tag)) {
        $rows[] = [$tagToDisplay, '', $tagLabel, '', $value];
      } else if ($tag == 'leader') {
        $rows[] = ['LDR', '', 'leader', '', $value];
      } else {
        if (!is_null($value) && is_array($value) && !empty($value)) {
          foreach ($value as $instance) {
            $rows[] = [$tagToDisplay, '', $tagLabel, '', ''];
            $hasInd1 = $tag_defined && isset($definition->indicator1) && !is_null($definition->indicator1);
            $ind1Label = $hasInd1 ? $definition->indicator1->label : '';
            $ind1Value = $hasInd1 && isset($definition->indicator1->codes->{$instance->ind1})
              ? $definition->indicator1->codes->{$instance->ind1}->label : '';
            if ($ind1Label != '' || $ind1Value != '' || $instance->ind1 != ' ')
              $rows[] = ['', 'ind1', $ind1Label, $instance->ind1, $ind1Value];

            $hasInd2 = $tag_defined && isset($definition->indicator2) && !is_null($definition->indicator2);
            $ind2Label = $hasInd2 ? $definition->indicator2->label : '';
            $ind2Value = $hasInd2 && isset($definition->indicator2->codes->{$instance->ind2})
              ? $definition->indicator2->codes->{$instance->ind2}->label : '';
            if ($ind2Label != '' || $ind2Value != '' || $instance->ind2 != ' ')
              $rows[] = ['', 'ind2', $ind2Label, $instance->ind2, $ind2Value];

            foreach ($instance->subfields as $code => $s_value) {
              $hasCode = $tag_defined && isset($definition->subfields) && isset($definition->subfields->{$code});
              $codeLabel = $hasCode ? $definition->subfields->{$code}->label : '';
              $rows[] = ['', '$' . $code, $codeLabel, '', $s_value];
            }
          }
        }
      }
    }
    return $rows;
  }

  public static function initializeSchema($schemaType) {
    if (!self::$isSchemaInitialized) {
      if ($schemaType == 'MARC21') {
        self::initializeMarcFields();
      } elseif ($schemaType == 'PICA') {
        self::initializeSchemaManager();
      }
      self::$isSchemaInitialized = true;
    }
  }

  public static function initializeSchemaManager() {
    if (is_null(self::$schema)) {
      include_once('pica/PicaSchemaManager.php');
      self::$schema = new PicaSchemaManager();
    }
  }

  public static function initializeMarcFields() {
    if (is_null(self::$fields)) {
      self::$fields = json_decode(file_get_contents('schemas/marc-schema-with-solr-and-extensions.json'))->fields;
    }
  }

  public function resolvePicaFields($schemaType = 'PICA'): array {
    self::initializeSchema($schemaType);

    $rows = [];
    foreach ($this->record as $tag => $value) {
      $definition = self::$schema->lookup($tag);
      $tag_defined = $definition != false;
      if ($tag_defined && !isset($definition->label))
        error_log(' no tag label for ' . $tag);
      $tagLabel = $tag_defined ? $definition->label : '';
      if (!is_null($value) && is_array($value) && !empty($value)) {
        $tagToDisplay = $this->picaTagLink($tag);
        foreach ($value as $instance) {
          $rows[] = [$tagToDisplay, (object)['span' => 4, 'text' => $tagLabel]];

          foreach ($instance->subfields as $code => $s_value) {
            $hasCode = $tag_defined && isset($definition->subfields) && isset($definition->subfields->{$code});
            $codeLabel = $hasCode ? $definition->subfields->{$code}->label : '';
            $codeToDisplay = '$' . $code;
            // if (isset($definition->url))
            //   $codeToDisplay = (object)['url' => $definition->url . '#$' . $code, 'text' => '$' . $code];
            $rows[] = ['', $codeToDisplay, $codeLabel, '', $s_value];
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
    $filters = [];
    if (is_array($value))
      foreach ($value as $v)
        $filters[] = 'filters[]=' . urlencode(sprintf('%s:"%s"', $field, $v));
    else
      $filters[] = 'filters[]=' . urlencode(sprintf('%s:"%s"', $field, $value));
    return '?' . join('&', array_merge($filters, $this->basicFilterParameters));
  }

  public function get007Category() {
    static $categories;
    if (!isset($categories)) {
      $categories = [
        "a" => "Map",
        "c" => "Electronic resource",
        "d" => "Globe",
        "f" => "Tactile material",
        "g" => "Projected graphic",
        "h" => "Microform",
        "k" => "Nonprojected graphic",
        "m" => "Motion picture",
        "o" => "Kit",
        "q" => "Notated music",
        "r" => "Remote-sensing image",
        "s" => "Sound recording",
        "t" => "Text",
        "v" => "Videorecording",
        "z" => "Unspecified"
      ];
    }
    $tag = $this->getField('007');
    if (!is_null($tag)) {
      $category = substr($tag, 0, 1);
      if (isset($categories[$category]))
        return $categories[$category];
    }
    return $categories['t'];
  }

  public function get006Type() {
    static $categories;
    if (!isset($categories)) {
      $categories = [
        "a" => "Books",
        "c" => "Music",
        "d" => "Music",
        "e" => "Maps",
        "f" => "Maps",
        "g" => "Visual Materials",
        "i" => "Music",
        "j" => "Music",
        "k" => "Visual Materials",
        "m" => "Computer Files",
        "o" => "Visual Materials",
        "p" => "Mixed Materials",
        "r" => "Visual Materials",
        "s" => "Continuing Resources",
        "t" => "Books"
      ];
    }
    $tag = $this->getField('006');
    if (!is_null($tag)) {
      $category = substr($tag, 0, 1);
      if (isset($categories[$category]))
        return $categories[$category];
    }
    return $categories['t'];
  }

  public function getDoc() {
    return $this->doc;
  }

  private function marcTagLink($tag, $definition) {
    $tagToDisplay = $tag;
    if (!is_null($definition) && isset($definition->url))
      $tagToDisplay = (object)['url' => $definition->url, 'text' => $tag];
    return $tagToDisplay;
  }

  private function picaTagLink($tag, $pica3=true) {
    $text = $tag;
    $field = self::$schema->lookup($tag);
    if ($pica3 && isset($field->pica3))
      $text .= '=' . $field->pica3;

    if (isset($field->url))
      $tagToDisplay = (object)['url' => $field->url, 'text' => $text];
    else
      $tagToDisplay = $text;

    return $tagToDisplay;
  }

}
