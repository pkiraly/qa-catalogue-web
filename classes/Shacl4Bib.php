<?php

class Shacl4Bib extends BaseTab {

  public static String $paramsFile = 'shacl.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters(Shacl4Bib::$paramsFile);
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

  public function getTemplate() {
    return 'shacl/shacl.tpl';
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
}