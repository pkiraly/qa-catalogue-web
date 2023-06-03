<?php

class Shacl4Bib extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters('shacl.params.json');
    $schemaFile = $this->analysisParameters->shaclConfigurationFile;
    $schemaFile = $this->getFilePath(substr($schemaFile, strrpos($schemaFile, '/') + 1));
    $isYaml = preg_match('/\.ya?ml$/', $schemaFile);
    $rawContent = file_get_contents($schemaFile);
    $schema = $isYaml ? yaml_parse($rawContent) : json_decode($rawContent);

    $result = readCsv($this->getFilePath('shacl4bib-stat.csv'), 'id');
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