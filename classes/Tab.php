<?php

abstract class Tab {
  /**
   * List of implemented tabs.
   * TODO: can be generated automatically with
   * strtolower(preg_replace('/([A-Z])/','-$1', lcfirst($class)))
   */
  protected const names = [
    'dashboard'                => 'Dashboard',
    'data'                     => 'Data',
    'completeness'             => 'Completeness',
    'issues'                   => 'Issues',
    'functions'                => 'Functions',
    'classifications'          => 'Classifications',
    'authorities'              => 'Authorities',
    'serials'                  => 'Serials',
    'tt-completeness'          => 'TtCompleteness',
    'shelf-ready-completeness' => 'ShelfReadyCompleteness',
    'shacl'                    => 'Shacl',
    'network'                  => 'Network',
    'terms'                    => 'Terms',
    'pareto'                   => 'Pareto',
    'history'                  => 'History',
    'timeline'                 => 'Timeline',
    'settings'                 => 'Settings',
    'about'                    => 'About',
    'record-issues'            => 'RecordIssues',
    'histogram'                => 'Histogram',
    'functional-analysis-histogram' => 'FunctionalAnalysisHistogram',
    'control-fields'           => 'ControlFields',
    'download'                 => 'Download',
    'collocations'             => 'Collocations',
  ];

  public static function create($name, $config): Tab {
    $class = Tab::names[$name];
    return new $class($config, $config->getId()); 
  }

  public static function defined($name): bool {
    return array_key_exists($name, Tab::names);
  }

  public abstract function prepareData(Smarty &$smarty);
  public abstract function getTemplate();
}
