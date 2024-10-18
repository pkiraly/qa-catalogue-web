<?php

class Shacl extends BaseTab {

  protected string $action = 'list';
  protected $parameterFile = 'shacl4bib.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $this->action = getOrDefault('action', 'list', ['list', 'download']);

    if ($this->action == 'download') {
      $this->processDownloadRequest();
    } else {
      $this->processListRequest($smarty);
    }
  }

  public function getTemplate() {
    return 'shacl/shacl.tpl';
  }

  private function processListRequest(&$smarty) {
    $schemaFile = $this->analysisParameters->shaclConfigurationFile;
    $schemaFile = substr($schemaFile, strrpos($schemaFile, '/') + 1);
    $schemaFilePath = $this->getFilePath($schemaFile);
    $isYaml = preg_match('/\.ya?ml$/', $schemaFile);
    $rawContent = file_get_contents($schemaFilePath);
    $schema = $isYaml ? yaml_parse($rawContent) : json_decode($rawContent);

    $result = readCsv($this->getFilePath('shacl4bib-stat.csv'), 'id');
    $smarty->assign('schemaFile', $schemaFile);
    $smarty->assign('result', $result);
    $smarty->assign('index', $this->indexSchema($schema));
  }

  private function indexSchema($schema) {
    $index = [];
    foreach ($schema['fields'] as $field) {
      if (isset($field['rules'])) {
        $path = $field['path'];
        foreach ($field['rules'] as $rule) {
          $id = $rule['id'];
          unset($rule['id']);
          $rule['path'] = $path;
          $index[$id] = $rule;
        }
      }
    }
    return $index;
  }

  public function showArray($name, $criterium) {
    $text = $name;
    $elements = [];
    $isList = array_is_list($criterium);
    foreach ($criterium as $key => $value) {
      if (is_array($value)) {
        if ($isList)
          $elements[] = $this->showArray('', $value);
        else
          $elements[] = $this->showArray($key, $value);
      } else {
        $valueStr = is_bool($value) ? var_export($value, true) : $value;
        if ($isList)
          $elements[] = $valueStr;
        else
          $elements[] = $key . '=' . $valueStr;
      }
    }
    $elementsStr = join(', ', $elements);
    if ($isList)
      $text .= '(' . $elementsStr . ')';
    else
      $text .= $elementsStr;

    return $text;
  }

  public function queryUrl($id, $value) {
    return sprintf('?tab=data&type=custom-rule&query=%s:%s', $id, $value);
  }

  public function downloadUrl($id, $value) {
    $baseParams = [
      'tab=shacl',
      'action=download',
    ];
    $params = array_merge($baseParams, $this->getGeneralParams());
    $params[] = sprintf('ruleId=%s', $id);
    $params[] = sprintf('value=%s', $value);
    return '?' . join('&', $params);
  }

  private function processDownloadRequest() {
    $ruleId = getOrDefault('ruleId', '');
    $value = getOrDefault('value', '');
    if ($ruleId != '') {
      $this->output = 'none';
      $this->download($ruleId, $value);
    }
  }

  private function download($ruleId, $value) {
    $groupId = '';
    $attachment = sprintf('attachment; filename="shacl-issue-%s-is-%s-at-%s.csv"', $ruleId, $value, date("Y-m-d"));
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: ' . $attachment);

    if ($ruleId != '') {
      if ($this->sqliteExists()) {
        $this->numFound = $this->issueDB()->getRecordIdsByShaclCount($ruleId, $value, $groupId)->fetchArray(SQLITE3_ASSOC)['count'];
        $result = $this->issueDB()->getRecordIdsByShacl($ruleId, $value, $groupId);
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
          echo $row['id'], "\n";
      # } else {
      #   $recordIds = $this->getIdsFromCsv($errorId, $this->action);
      #   echo join("\n", $recordIds);
      }
    }
  }

}
