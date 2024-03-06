<?php


class Functions extends BaseTab {

  protected $functions = [
    'DiscoverySearch' => [
      'label' => 'Discovery: Search',
      'text' => 'Search for a resource corresponding to stated criteria (i.e., to search either a single entity or a set of entities using an attribute or relationship of the entity as the search criteria).'
    ],
    'DiscoveryIdentify' => [
      'label' => 'Discovery: Identify',
      'text' => 'Identify a resource (i.e., to confirm that the entity described or located corresponds to the entity sought, or to distinguish between two or more entities with similar characteristics).'
    ],
    'DiscoverySelect' => [
      'label' => 'Discovery: Select',
      'text' => 'Select a resource that is appropriate to the user’s needs (i.e., to choose an entity that meets the user’s requirements with respect to content, physical format, etc., or to reject an entity as being inappropriate to the user’s needs).'
    ],
    'DiscoveryObtain' => [
      'label' => 'Discovery: Obtain',
      'text' => 'Access a resource either physically or electronically through an online connection to a remote computer, and/or acquire a resource through purchase, licence, loan, etc.'
    ],
    'UseRestrict' => [
      'label' => 'Use: Restrict',
      'text' => 'Control access to or use of a resource (i.e., to restrict access to and/or use of an entity on the basis of proprietary rights, administrative policy, etc.).'
    ],
    'UseManage' => [
      'label' => 'Use: Manage',
      'text' => 'Manage a resource in the course of acquisition, circulation, preservation, etc.'
    ],
    'UseOperate' => [
      'label' => 'Use: Operate',
      'text' => 'Operate a resource (i.e., to open, display, play, activate, run, etc. an entity that requires specialized equipment, software, etc. for its operation).'
    ],
    'UseInterpret' => [
      'label' => 'Use: Interpret',
      'text' => 'Interpret or assess the information contained in a resource.'
    ],
    'ManagementIdentify' => [
      'label' => 'Management: Identify',
      'text' => 'Identify a record, segment, field, or data element (i.e., to differentiate one logical data component from another).'
    ],
    'ManagementProcess' => [
      'label' => 'Management: Process',
      'text' => 'Process a record, segment, field, or data element (i.e., to add, delete, replace, output, etc. a logical data component by means of an automated process).'
    ],
    'ManagementSort' => [
      'label' => 'Management: Sort',
      'text' => 'Sort a field for purposes of alphabetic or numeric arrangement.'
    ],
    'ManagementDisplay' => [
      'label' => 'Management: Display',
      'text' => 'Display a field or data element (i.e., to display a field or data element with the appropriate print constant or as a tracing).'
    ]
  ];

  protected $function;
  protected $parameterFile = 'functions.params.json';

  public function __construct($configuration, $id) {
    parent::__construct($configuration, $id);

    $this->function = getOrDefault('function', 'DiscoverySearch', array_keys($this->functions));
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('function', $this->function);
    $smarty->assign('label', $this->functions[$this->function]['label']);
    $smarty->assign('text', $this->functions[$this->function]['text']);
    $this->readFieldList($smarty);
  }

  public function getTemplate() {
    return 'functions.tpl';
  }

  private function readFieldList(Smarty &$smarty) {
    $elements = $this->readMarcElements();

    $file = $this->getFilePath('functional-analysis-mapping.csv');
    if (file_exists($file)) {
      $records = readCsv($file);
      foreach ($records as $record) {
        if ($record->frbrfunction == $this->function) {
          $smarty->assign('fieldCount', $record->count);
          $rawFields = explode(';', $record->fields);
          $fields = [];
          foreach ($rawFields as $field) {
            $item = (object)['name' => $field];
            if (preg_match('/ind[12]$/', $field)) {
              $tag = substr($field, 0, 3);
              if (isset($elements[$tag]))
                $item->link = $tag;
            } else {
              if (isset($elements[$field]))
                $item->link = $field;
            }
            $fields[] = $item;
          }
          $smarty->assign('fields', $fields);
        }
      }
    }
  }

  private function readMarcElements() {
    $elements = [];
    $file = $this->getFilePath('marc-elements.csv');
    if (file_exists($file)) {
      $records = readCsv($file);
      foreach ($records as $record) {
        $elements[$record->path] = 1;
        $tag = substr($record->path, 0, 3);
        if (!isset($elements[$tag]))
          $elements[$tag] = 1;
      }
    }
    return $elements;
  }
}