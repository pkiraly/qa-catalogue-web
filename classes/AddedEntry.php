<?php


class AddedEntry extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $this->grouped = !is_null($this->analysisParameters) && !empty($this->analysisParameters->groupBy);
    $this->groupId = getOrDefault('groupId', 0);
  }

  protected function ind1Orsubfield2(&$record, $ind1, $subfield2) {
    $debug = FALSE; // ($record->field == '052');
    if ($debug)
      error_log('location: ' . $record->location);
    // Query in form of "052ind1_GeographicClassification_codeSource_ss
    // Or starting with "0522_GeographicClassification_source_ss:scheme"

    // %%22 is actually %22 in the URL encoding, which is a double quote (")
    if ($record->location == 'ind1') {
      $record->q = sprintf('%s:%%22%s%%22', $ind1, $record->scheme);
    } elseif ($record->location == '$2') {
      if ($record->scheme == 'undetectable') {
        $record->q = sprintf('%s:%%22Source specified in subfield \$2%%22 NOT %s:*', $ind1, $subfield2);
      } else {
        $record->q = sprintf('%s:%%22%s%%22', $subfield2, $record->scheme);
      }
    }
    if ($debug)
      error_log('q: ' . $record->q);
  }

  protected function ind2Orsubfield2(&$record, $ind2, $subfield2) {
    if ($record->location == 'ind2') {
      $record->q = sprintf('%s:%%22%s%%22', $ind2, $record->scheme);
    } else if ($record->location == '$2') {
      if ($record->scheme == 'undetectable') {
        $record->q = sprintf('%s:%%22Source specified in subfield \$2%%22 NOT %s:*', $ind2, $subfield2);
      } else {
        $record->q = sprintf('%s:%%22%s%%22', $subfield2, $record->scheme);
      }
    }
  }

  protected function subfield0or2(&$record, $name) {
    $subfield0 = sprintf('%s0_%s_authorityRecordControlNumber_organizationCode_ss', $record->field, $name);
    $subfield2 = sprintf('%s2_%s_source_ss', $record->field, $name);
    if ($record->location == '$0') {
      $record->q = sprintf('%s:%%22%s%%22', $subfield0, $record->abbreviation);
    } else if ($record->location == '$2') {
      if ($record->scheme == 'undetectable') {
        $record->q = sprintf('%s:* NOT %s:*', $record->facet, $subfield2);
      } else {
        $record->q = sprintf('%s:%%22%s%%22', $subfield2, urlencode($record->abbreviation));
      }
    }
  }

  /**
   * @param Smarty $smarty
   * @return object
   */
  protected function readElements(Smarty &$smarty) {
    $t0 = microtime(true);
    $tArrayCombine = 0.0;
    $fileName = $this->grouped ? 'completeness-grouped-marc-elements.csv' : 'marc-elements.csv';
    $elementsFile = $this->getFilePath($fileName);
    $useDB = true;
    if (file_exists($elementsFile)) {
      $elements = [];
      if ($useDB && $this->hasMarcElementTable()) {
        error_log('read data elements from DB');
        $result = $this->issueDB->getMarcElements('all', ($this->grouped ? $this->groupId : ''));
        while ($record = $result->fetchArray(SQLITE3_ASSOC)) {
          $elements[$record['path']] = $record['subfield'];
        }
      } else {
        error_log('read data elements from: ' . $elementsFile);
        $header = [];
        $in = fopen($elementsFile, "r");
        while (($line = fgets($in)) != false) {
          $values = str_getcsv($line);
          if (empty($header)) {
            $header = $values;
          } else {
            $tArrayCombine0 = microtime(true);
            $record = (object)array_combine($header, $values);
            $tArrayCombine += microtime(true) - $tArrayCombine0;
            if ($this->grouped && $record->groupId != $this->groupId)
              continue;

            $elements[$record->path] = $record->subfield;
          }
        }
      }
      $smarty->assign('hasElements', TRUE);
      $smarty->assign('elements', $elements);
    } else {
      $smarty->assign('hasElements', FALSE);
    }
  }

  /**
   * @param Smarty $smarty
   * @param Smarty $bySubfieldsFile
   * @return object
   */
  protected function readSubfields(Smarty &$smarty, $bySubfieldsFile) {
    if (file_exists($bySubfieldsFile)) {
      error_log('bySubfieldsFile: ' . $bySubfieldsFile);
      $header = [];
      $subfields = [];
      $subfieldsById = [];
      $in = fopen($bySubfieldsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          if (count($header) != count($values)) {
            error_log("wrong line: " . $line);
            continue;
          }
          $record = (object)array_combine($header, $values);
          if (!isset($record->subfields)) {
            error_log('no subfields: ' . $line . ' (' . $bySubfieldsFile . ')');
          }
          $record->subfields = explode(';', $record->subfields);
          $items = [];
          $hasPlus = FALSE;
          $hasSpace = FALSE;
          foreach ($record->subfields as $subfield) {
            if ($subfield == ' ') {
              $subfield = '_';
              $hasSpace = TRUE;
            }
            $subfield = '$' . $subfield;
            $items[] = $subfield;
            if (preg_match('/\+$/', $subfield)) {
              $hasPlus = TRUE;
              $subfield = str_replace('+', '', $subfield);
            }
            if (!isset($subfieldsById[$record->id]))
              $subfieldsById[$record->id] = [];
            if (!in_array($subfield, $subfieldsById[$record->id]))
              $subfieldsById[$record->id][] = $subfield;
          }
          $record->subfields = $items;
          if (!isset($subfields[$record->id])) {
            $subfields[$record->id] = ['list' => [], 'has-plus' => FALSE, 'has-space' => FALSE];
          }
          $subfields[$record->id]['list'][] = $record;
          if ($hasPlus)
            $subfields[$record->id]['has-plus'] = TRUE;
          if ($hasSpace)
            $subfields[$record->id]['has-space'] = TRUE;
        }
      }

      $smarty->assign('subfields', $subfields);
      $smarty->assign('hasSubfields', TRUE);
      $smarty->assign('matrices', $this->createMatrix($subfields));

      foreach ($subfieldsById as $id => $subfields) {
        sort($subfields);
        $nums = [];
        $alpha = [];
        foreach ($subfields as $subfield) {
          if (preg_match('/\d$/', $subfield)) {
            $nums[] = $subfield;
          } else {
            $alpha[] = $subfield;
          }
        }
        $subfields = array_merge($alpha, $nums);
        $subfieldsById[$id] = $subfields;
      }

      $smarty->assign('subfieldsById', $subfieldsById);
    } else {
      $smarty->assign('hasSubfields', FALSE);
    }
  }

  /**
   * This method is used to create facets for a given field. The method sets the facet and facet2 properties of the
   * classificationRecord object.
   * @param object $classificationRecord Represents a bibliographic field, result of the classification process
   *                                     (not to mistake for a bibliographic record).
   * @param string $base The base name for the facet.
   */
  protected function createFacets(object &$classificationRecord, string $base) {
    $classificationRecord->facet = $base . '_ss';

    // The main difference between abbreviation and abbreviation4solr is that the latter gets stripped of
    // special characters or whitespaces.
    // This part with abbreviations is supposed to target the indexFieldsWithSchemas part of the Solr indexing in
    // the qa-catalogue tool.
    if (isset($classificationRecord->abbreviation4solr)
        && $classificationRecord->abbreviation4solr != ''
        && in_array($classificationRecord->abbreviation4solr, $this->solr()->getSolrFields())) {
      $classificationRecord->facet2 = $base . '_' . $classificationRecord->abbreviation4solr . '_ss';
      return;
    }

    if (isset($classificationRecord->abbreviation)
        && $classificationRecord->abbreviation != ''
        && in_array($classificationRecord->abbreviation, $this->solr()->getSolrFields())) {
      $classificationRecord->facet2 = $base . '_' . $classificationRecord->abbreviation . '_ss';
    }
  }

  /**
   * @param $subfields
   * {
   *    recordId =» {
   *      'list' =» [{"id" =» ..., "subfields" =» ["$.","$.","$."],"count" =» ...}, ...]
   * 	    'has-plus' =» true,
   *      'has-space' =» false
   *    },
   *    ...
   * }
   */
  protected function createMatrix($subfields) {
    $matrices = [];
    foreach ($subfields as $recordId => $entry) {
      $total = 0;
      $matrix = [];
      $widths = [];
      foreach ($entry['list'] as $lineNr => $listItem) {
        $number = intval($listItem->count);
        $total += $number;
        foreach ($listItem->subfields as $code) {
          $code = str_replace('+', '', $code);
          if (!isset($matrix[$code]))
            $matrix[$code] = [];
          $matrix[$code][$lineNr] = $number;
          $widths[$lineNr] = ['abs' => $number];
        }
      }

      foreach ($matrix as $code => $codes) {
        for ($i = 0; $i <= $lineNr; $i++) {
          $key = $i;
          if (!isset($codes[$key]))
            $codes[$key] = 0;
        }
        ksort($codes);
        $matrix[$code] = $codes;
      }

      for ($i = 0; $i <= $lineNr; $i++) {
        $widths[$i]['perc'] = ceil($widths[$i]['abs'] * 100000 / $total) / 100000;
      }

      $matrices[$recordId] = [
        'codes' => $matrix,
        'widths' => $widths,
        'total' => $total
      ];
    }
    return $matrices;
  }

  public function termLink($facet, $query, $scheme) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=terms',
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if (isset($this->version) && !empty($this->version))
        $baseParams[] = 'version=' . $this->version;
      if (isset($this->groupId) && !empty($this->groupId))
        $baseParams[] = 'groupId=' . $this->groupId;
      /*
      */
    }
    $params = $baseParams;
    $params[] = 'facet=' . $facet;
    $params[] = 'query=' . $query;
    if (!is_null($scheme))
      $params[] = 'scheme=' . urlencode(sprintf('"%s"', $scheme));

    return '?' . join('&', $params);
  }

  public function queryLink($id) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=data',
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if (isset($this->version) && !empty($this->version))
        $baseParams[] = 'version=' . $this->version;
      if (isset($this->groupId) && !empty($this->groupId))
        $baseParams[] = 'groupId=' . $this->groupId;
    }
    $params = $baseParams;
    $params[] = 'query=' . urlencode(sprintf('id:"%s"', $id));
    return '?' . join('&', $params);
  }

  public function completenessLink($key) {
    static $baseParams;
    if (!isset($baseParams)) {
      $baseParams = [
        'tab=completeness',
      ];
      $baseParams = array_merge($baseParams, $this->getGeneralParams());
      if (isset($this->version) && !empty($this->version))
        $baseParams[] = 'version=' . $this->version;
      if (isset($this->groupId) && !empty($this->groupId))
        $baseParams[] = 'groupId=' . $this->groupId;
    }
    $params = $baseParams;
    return '?' . join('&', $params) . '#completeness-' . $key;
  }
}
