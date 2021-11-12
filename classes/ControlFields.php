<?php

class ControlFields extends BaseTab {

  private $solrFieldsMap = [];
  private static $supportedPositions = [
    'Leader' => ['05', '06', '07', '08', '09', '17', '18', '19'],
    '006' => ['00'],
  ];
  private $field;
  private $position;

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $this->action = getOrDefault('action', 'list', ['list', 'histogram']);

    $this->mapSolrFields();
    $this->field = getOrDefault('field', 'Leader', array_keys(self::$supportedPositions));
    $this->position = getOrDefault('position', self::$supportedPositions[$this->field][0], self::$supportedPositions[$this->field]);

    $solrField = $this->solrFieldsMap[$this->field][$this->position]->solr;
    $termResponse = $this->getFacets($solrField, '*:*', 100, 0);
    $terms = $termResponse->{$solrField};
    $count = count(get_object_vars($terms));

    if ($this->action == 'histogram') {
      $this->output = 'none';
      $this->asCsv($terms);
    // if ($this->action == 'list') {
    } else {
      $smarty->assign('terms', $terms);
      $smarty->assign('count', $count);
      $smarty->assign('selectedField', $this->field);
      $smarty->assign('selectedPosition', $this->position);
      $smarty->assign('supportedPositions', self::$supportedPositions);
      $smarty->assign('solrFieldsMap', $this->solrFieldsMap);
      $smarty->assign('solrField', $solrField);
      $smarty->assign('controller', $this);
    }
  }

  public function getTemplate() {
    return 'control-fields.tpl';
  }

  public function getAjaxTemplate() {
    return null;
  }

  private function mapSolrFields() {
    foreach ($this->getSolrFields() as $field) {
      if (preg_match('/^leader(\d\d)/', $field, $matches)) {
        $position = $matches[1];
        if (in_array($position, self::$supportedPositions['Leader'])) {
          $this->solrFieldsMap['Leader'][$position] = (object)[
            'solr' => $field,
            'label' => $this->getFieldDefinitions()->fields->{'LDR'}->positions->{$position}->label
          ];
        }
      } elseif (preg_match('/^006all(\d\d)/', $field, $matches)) {
        $position = $matches[1];
        if (in_array($position, self::$supportedPositions['006'])) {
          $this->solrFieldsMap['006'][$position] = (object)[
            'solr' => $field,
            'label' => $this->getFieldDefinitions()->fields->{'006'}->types->{'All Materials'}->positions->{$position}->label
          ];
        }
      }

    }

  }

  private function createTermList() {
    return $this->getFacets($this->facet, $this->query, $this->facetLimit, $this->offset);
  }

  private function asCsv($terms) {
    header("Content-type: text/csv");
    echo $this->formatAsCsv($terms);
  }

  private function formatAsCsv($terms) {
    $lines = ['term,count'];
    foreach ($terms as $key => $value)
      $lines[] = sprintf('"%s",%d', $key, $value);

    return join("\n", $lines);
  }


}