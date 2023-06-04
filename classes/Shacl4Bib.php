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
        foreach ($field['rules'] as $rule) {
          $id = $rule['id'];
          unset($rule['id']);
          $index[$id] = $rule;
        }
      }
    }
    return $index;
  }

}