<?php

class ControlFields extends BaseTab {

  private $solrFieldsMap = [
    'Leader' => [],
    '006' => [],
    '007' => [],
    '008' => [],
  ];
  private $supportedPositions = [
    'Leader' => ['05', '06', '07', '08', '09', '17', '18', '19'],
    '006' => [],
    '007' => [],
    '008' => [],
  ];
  private $field;
  private $type;
  private $position;

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $this->action = getOrDefault('action', 'list', ['list', 'histogram']);

    $this->mapSolrFields();
    $this->field = getOrDefault('field', 'Leader', array_keys($this->supportedPositions));
    $this->type = ($this->field == 'Leader')
      ? ''
      : getOrDefault('type', '', array_keys($this->solrFieldsMap[$this->field]));
    $this->position = getOrDefault('position', $this->supportedPositions[$this->field][0], $this->supportedPositions[$this->field]);

    $solrField = ($this->field == 'Leader')
      ? $this->solrFieldsMap[$this->field][$this->position]->solr
      : $this->solrFieldsMap[$this->field][$this->type][$this->position]->solr;
    $solrField = preg_replace('/_tt$/', '_ss', $solrField);
    // TODO: this will throw an Exception if Solr is not reachable
    $termResponse = $this->solr()->getFacets($solrField, '*:*', 100, 0);
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
      $smarty->assign('selectedType', $this->type);
      $smarty->assign('selectedPosition', $this->position);
      $smarty->assign('supportedPositions', $this->supportedPositions);
      $smarty->assign('solrFieldsMap', $this->solrFieldsMap);
      $smarty->assign('solrField', $solrField);
    }
  }

  public function getTemplate() {
    return 'control-fields.tpl';
  }

  public function getAjaxTemplate() {
    return null;
  }

  private function mapSolrFields() {
    $fields = $this->getFieldDefinitions()->fields;
    foreach ($this->solr()->getSolrFields() as $field) {
      if (preg_match('/^leader(\d\d)/', $field, $matches)) {
        $position = $matches[1];
        if (in_array($position, $this->supportedPositions['Leader'])) {
          $this->solrFieldsMap['Leader'][$position] = (object)[
            'solr' => $field,
            'label' => $this->getFieldDefinitions()->fields->{'LDR'}->positions->{$position}->label
          ];
        }
      } elseif (preg_match('/^(00[678])/', $field, $matches)) {
        $marcField = $matches[1];
        $in_schema = preg_replace('/_ss$/', '', $field);
        foreach ($fields->{$marcField}->types as $label => $type) {
          foreach ($type->positions as $position => $properties) {
            $this->supportedPositions[$marcField][] = $position;
            if ($properties->solr == $in_schema) {
              $this->solrFieldsMap[$marcField][$label][$position] = (object)[
                'solr' => $field,
                'label' => $properties->label
              ];
            }
          }
        }
      }
    }

    foreach ($this->solrFieldsMap as $field => $props) {
      if (empty($props)) {
        unset($this->solrFieldsMap[$field]);
        continue;
      }

      ksort($this->solrFieldsMap[$field]);
      if ($field != 'Leader') {
        foreach ($props as $pos => $ps) {
          ksort($this->solrFieldsMap[$field][$pos]);
        }
      }
    }
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
