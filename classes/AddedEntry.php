<?php


class AddedEntry extends BaseTab {

  protected function ind1Orsubfield2(&$record, $ind1, $subfield2) {
    $debug = FALSE; // ($record->field == '052');
    if ($debug)
      error_log('location: ' . $record->location);

    if ($record->location == 'ind1') {
      $record->q = sprintf('%s:%%22%s%%22', $ind1, $record->scheme);
    } else if ($record->location == '$2') {
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
   * @param $dir
   * @param $db
   * @param Smarty $smarty
   * @return object
   */
  protected function readElements(Smarty &$smarty) {
    $elementsFile = $this->getFilePath('marc-elements.csv');
    if (file_exists($elementsFile)) {
      $header = [];
      $elements = [];
      $in = fopen($elementsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $elements[$record->path] = $record->subfield;
        }
      }
      $smarty->assign('hasElements', TRUE);
      $smarty->assign('elements', $elements);
    } else {
      $smarty->assign('hasElements', FALSE);
    }
  }

  /**
   * @param $dir
   * @param $db
   * @param Smarty $smarty
   * @return object
   */
  protected function readSubfields(Smarty &$smarty, $bySubfieldsFile) {
    if (file_exists($bySubfieldsFile)) {
      $header = [];
      $subfields = [];
      $subfieldsById = [];
      $in = fopen($bySubfieldsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
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
   * @param $record
   * @param $base
   */
  protected function createFacets(&$record, $base) {
    $record->facet = $base . '_ss';

    if (isset($record->abbreviation4solr)
        && $record->abbreviation4solr != ''
        && in_array($record->abbreviation4solr, $this->getSolrFields())) {
      $record->facet2 = $base . '_' . $record->abbreviation4solr . '_ss';
    } elseif (isset($record->abbreviation)
        && $record->abbreviation != ''
        && in_array($record->abbreviation, $this->getSolrFields())) {
      $record->facet2 = $base . '_' . $record->abbreviation . '_ss';
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
}
