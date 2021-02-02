<?php


class Settings extends BaseTab {

  private $categories = [];

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    if (!empty($_POST)) {
      $smarty->assign('saved', true);
      $selectedFacets = getPostedOrDefault('facet', []);
      $success = $this->saveSelectedFacets($selectedFacets);
      $smarty->assign('success', $success);
    } else {
      $smarty->assign('saved', false);
    }

    $smarty->assign('facets', $this->getFields());
    $smarty->assign('categories', $this->categories);
  }

  public function getTemplate() {
    return 'settings.tpl';
  }

  private function getFields() {
    $fields = [];
    $selectedFacets = $this->getSelectedFacets();
    $fieldNames = $this->getSolrFields();
    sort($fieldNames);

    foreach ($fieldNames as $fieldName) {
      if (preg_match('/^\d{3}/', $fieldName)) {
        $category = $this->getCategoryGroup($fieldName);
      } elseif (preg_match('/^Leader/', $fieldName)) {
        $category = 'Leader';
      } else {
        $category = 'other';
      }
      if (!isset($this->categories[$category])) {
        $this->categories[$category] = [];
      }

      $field = (object)[
        'name' => $fieldName,
        'checked' => in_array($fieldName, $selectedFacets),
      ];
      $fields[] = $field;
      $this->categories[$category][] = $field;
    }
    return $fields;
  }

  private function saveSelectedFacets($selectedFacets) {
    $file = 'cache/selected-facets-' . $this->db . '.js';
    $fieldNames = $this->getSolrFields();
    $checkedFacets = [];
    foreach ($selectedFacets as $facet) {
      if (in_array($facet, $fieldNames))
        $checkedFacets[] = $facet;
    }

    return file_put_contents($file, json_encode($checkedFacets));
  }

  private function getCategoryGroup($fieldName) {
    $number = (int) substr($fieldName, 0, 3);
    if ($number < 10) {
      $category = '00X Control fields';
    } elseif ($number >= 10 && $number < 100) {
      $category = '01X-09X Numbers and Code';
    } elseif ($number >= 100 && $number < 200) {
      $category = '1XX Main Entry';
    } elseif ($number >= 200 && $number < 250) {
      $category = '20X-24X Title';
    } elseif ($number >= 250 && $number < 300) {
      $category = '25X-28X Edition, Imprint';
    } elseif ($number >= 300 && $number < 400) {
      $category = '3XX Physical Description';
    } elseif ($number >= 400 && $number < 500) {
      $category = '4XX Series Statement';
    } elseif ($number >= 500 && $number < 600) {
      $category = '5XX Note';
    } elseif ($number >= 600 && $number < 700) {
      $category = '6XX Subject Access';
    } elseif ($number >= 700 && $number < 760) {
      $category = '70X-75X Added Entry';
    } elseif ($number >= 760 && $number < 800) {
      $category = '76X-78X Linking Entry';
    } elseif ($number >= 800 && $number < 840) {
      $category = '80X-83X Series Added Entry';
    } elseif ($number >= 840 && $number < 900) {
      $category = '841-88X Holdings, Location, Alternate Graphics';
    } elseif ($number >= 900) {
      $category = '9XX Locally defined fields';
    } else {
      error_log(sprintf("%s -> %s", $fieldName, $number));
      $category = 'unknown';
    }
    return $category;
  }
}