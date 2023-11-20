<?php
set_time_limit(0);

$configFile = "configuration.cnf";

// catch incomplete installation
if (!file_exists('vendor/autoload.php')) {
  die("Installation incomplete: <code>composer install</code> must be run first!");
} elseif (!is_writable('_smarty') || !is_writable('cache')) {
  die("Installation incomplete: <code>_smarty</code> and <code>cache</code> must be writeable!");
} elseif(!file_exists($configFile)) {
  die("Installation incomplete: missing $configFile");
}

require 'vendor/autoload.php';

require_once 'common-functions.php';
require_once 'classes/utils/Configuration.php';

$configurationArray = parse_ini_file($configFile, false, INI_SCANNER_TYPED);
if (isset($configurationArray['id']) && $configurationArray['id'] != '')
  $id = $configurationArray['id'];
elseif (isset($configurationArray['db']) && $configurationArray['db'] != '')  // this is a deprecated parameter,
  $id = $configurationArray['db'];                                            // kept for compatibility reason
else
  $id = getPath();
$configuration = new Utils\Configuration($configurationArray, $id);

$smarty = createSmarty('templates');
$smarty->assign('templates', $configuration->getTemplates());

$map = [
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
  'shacl'                    => 'Shacl4Bib',
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

$defaultTab = getDefaultTab($configuration, $map, 'issues');
$tab = getOrDefault('tab', $defaultTab, array_keys($map));
$ajax = getOrDefault('ajax', 0, [0, 1]);
$smarty->assign('tab', $tab);
$smarty->assign('isCompleteness', in_array($tab, ['completeness', 'serials', 'tt-completeness', 'shelf-ready-completeness', 'functions']));
$smarty->assign('isValidation', in_array($tab, ['issues', 'shacl']));
$smarty->assign('isAuthority', in_array($tab, ['classifications', 'authorities']));
$smarty->assign('isTool', in_array($tab, ['terms', 'control-fields', 'collocations', 'download', 'settings']));
$languages = [
  'en' => 'en_GB.UTF-8',
  'de' => 'de_DE.UTF-8',
  'pt' => 'pt_BR.UTF-8'
];

include_once('classes/Tab.php');
include_once('classes/BaseTab.php');

$logger = $configuration->createLogger('index');

try {
  $class = $map[$tab] ?? $configuration->getDefaultTab();
  $tab = createTab($class);
} catch(Throwable $e) {
  $logger->error("Failed to initialize $class tab",(array)$e);
  // TODO: show another tab instead?
  die("Failed to initialize $class tab.");
}

try {
  $tab->prepareData($smarty);
} catch(Throwable $e) {
  $logger->error('Failed to read analysis result', (array)$e);
  $smarty->assign('error', 'Failed to read analysis result.');
}

if ($ajax == 1) {
  if (!is_null($tab->getAjaxTemplate()) && $tab->getOutputType() != 'none')
    $smarty->display($tab->getAjaxTemplate());
} elseif ($tab->getOutputType() == 'html')
  $smarty->display($tab->getTemplate());

function createTab($name) {
  global $configuration, $id;

  if ($name == 'Classifications' || $name == 'Authorities')
    include_once('classes/AddedEntry.php');

  include_once('classes/' . $name . '.php');
  return new $name($configuration, $id);
}

function showMarcUrl($content) {
  if (!preg_match('/^http/', $content))
    $content = 'https://www.loc.gov/marc/bibliographic/' . $content;

  return $content;
}

$facetLabels = [];
function getFacetLabel($facet) {
  global $facetLabels;
  if (isset($facetLabels[$facet]))
    return $facetLabels[$facet];
  return str_replace('_', ' ', preg_replace('/_ss$/', '', $facet));
}

/**
 * @param $configuration
 * @param array $map
 * @return mixed|string
 */
function getDefaultTab(Utils\Configuration $configuration, array $map, $defaultTab = 'issues') {
  $tab = $configuration->getDefaultTab();
  return in_array($tab, array_keys($map)) ? $tab : $defaultTab;
}
