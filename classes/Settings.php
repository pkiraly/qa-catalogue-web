<?php


class Settings extends BaseTab {

  public function prepareData(&$smarty) {
    if (!empty($_POST)) {
      $smarty->assign('saved', true);
      $selectedFacets = getPostedOrDefault('facet', []);
      $success = $this->saveSelectedFacets($selectedFacets);
      $smarty->assign('success', $success);
    } else {
      $smarty->assign('saved', false);
    }

    $smarty->assign('db',     $this->db);
    $smarty->assign('facets', $this->getFields());
  }

  public function getTemplate() {
    return 'settings.tpl';
  }

  private function getFields() {
    $fields = [];
    $selectedFacets = $this->getSelectedFacets();
    error_log(gettype($selectedFacets));
    $fieldNames = $this->getSolrFields();
    sort($fieldNames);

    foreach ($fieldNames as $fieldName) {
      $fields[] = (object)[
        'name' => $fieldName,
        'checked' => in_array($fieldName, $selectedFacets),
      ];
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
}