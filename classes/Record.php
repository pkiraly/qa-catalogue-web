<?php


class Record {
  private $configuration;
  private $db;
  private $doc;
  private $record;
  private $basicQueryParameters;
  private $basicFilterParameters;

  /**
   * Record constructor.
   * @param $doc
   */
  public function __construct($doc, $configuration, $db) {
    $this->doc = $doc;
    $this->record = json_decode($doc->record_sni);
    $this->configuration = $configuration;
    $this->db = $db;
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

    $catalogue = $this->db == 'metadata-qa' && isset($this->configuration['catalogue'])
        ? $this->configuration['catalogue']
        : $this->db;

    if ($catalogue == 'szte')
      return 'http://qulto.bibl.u-szeged.hu/record/-/record/' . trim($id);
    else if ($catalogue == 'mokka')
      return 'http://mokka.hu/web/guest/record/-/record/' . trim($id);
    else if ($catalogue == 'cerl') {
      $identifier = '';
      foreach ($this->doc->{'035a_SystemControlNumber_ss'} as $tag35a) {
        if (!preg_match('/OCoLC/', $tag35a)) {
          $identifier = $tag35a;
          break;
        }
      }
      return 'http://hpb.cerl.org/record/' . $identifier;
    } else if ($catalogue == 'dnb')
      return 'http://d-nb.info/' . trim($id);
    else if ($catalogue == 'gent')
      return 'https://lib.ugent.be/catalog/rug01:' . trim($id);
    else if ($catalogue == 'loc')
      return 'https://lccn.loc.gov/' . trim($id);
    else if ($catalogue == 'mtak')
      return 'https://mta-primotc.hosted.exlibrisgroup.com/permalink/f/1s1uct8/36MTA' . trim($id);
    else if ($catalogue == 'bayern')
      return 'http://gateway-bayern.de/' . trim($id);
    else if ($catalogue == 'bnpl') {
      foreach ($this->doc->{'035a_SystemControlNumber_ss'} as $tag35a) {
        if (preg_match('/^\d/', $tag35a)) {
          $identifier = $tag35a;
          break;
        }
      }
      return sprintf(
          'https://katalogi.bn.org.pl/discovery/fulldisplay?docid=alma%s&context=L&vid=48OMNIS_NLOP:48OMNIS_NLOP&search_scope=NLOP_IZ_NZ&tab=LibraryCatalog&lang=pl',
          trim($identifier));

    } else if ($catalogue == 'nfi') {
      // return 'https://melinda.kansalliskirjasto.fi/byid/' . trim($id);
      return 'https://kansalliskirjasto.finna.fi/Search/Results?bool0[]=OR&lookfor0[]=ctrlnum%3A%22FCC'
          . trim($id)
          . '%22&lookfor0[]=ctrlnum%3A%22(FI-MELINDA)'
          . trim($id)
          . '%22';
    } else if ($catalogue == 'gbv') {
      return sprintf('https://kxp.k10plus.de/DB=2.1/PPNSET?PPN=%s', trim($id));
    } else if ($catalogue == 'bl') {
      //      http://explore.bl.uk/BLVU1:LSCOP-ALL:BLL01015811469
      return 'http://explore.bl.uk/BLVU1:LSCOP-ALL:BLL01' . trim($id);
    }

    return '';
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

}