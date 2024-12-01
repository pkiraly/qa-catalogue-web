<?php

use Utils\Configuration;
// First check installation and initalize configuration

$configFile = "configuration.cnf";
$configDefaults = [
  "id" => preg_replace(',\/,', '', parse_url($_SERVER['REQUEST_URI'])['path'])
];

try {
  require 'vendor/autoload.php';
} catch(Throwable $e) {
  die("Installation incomplete: <code>composer install</code> must be run first!");
} 

if (!is_writable('_smarty') || !is_writable('cache')) {
  die("Installation incomplete: <code>_smarty</code> and <code>cache</code> must be writeable!");
} elseif(!file_exists($configFile)) {
  die("Installation incomplete: missing $configFile");
}

try {
  $configuration = Configuration::fromIniFile($configFile, $configDefaults);
} catch(Throwable $e) {
  die("Invalid configuration: " . $e->getMessage());
}

// Then initialize environment based on configuration
set_time_limit(0);
$general_log = $configuration->createLogger('qa-catalogue');

require_once 'common-functions.php';

$smarty = createSmarty('templates');
$smarty->assign('clientVersion', Utils\GitVersion::getVersion());
$smarty->assign('templates', $configuration->getTemplates());

$tab = getOrDefault('tab', $configuration->getDefaultTab());
if (!Tab::defined($tab)) $tab = 'issues';

$smarty->assign('tab', $tab);
$smarty->assign('isCompleteness', in_array($tab, ['completeness', 'serials', 'tt-completeness', 'shelf-ready-completeness', 'functions']));
$smarty->assign('isValidation', in_array($tab, ['issues', 'shacl', 'delta']));
$smarty->assign('isAuthority', in_array($tab, ['classifications', 'authorities']));
$smarty->assign('isTool', in_array($tab, ['terms', 'control-fields', 'collocations', 'download', 'settings']));
$languages = [
  'en' => 'en_GB.UTF-8',
  'de' => 'de_DE.UTF-8',
  'pt' => 'pt_BR.UTF-8',
  'hu' => 'hu_HU.UTF-8'
];

$logger = $configuration->createLogger('index');

try {
  $tab = Tab::create($tab, $configuration);
} catch(Throwable $e) {
  var_dump($e);
  $logger->error("Failed to initialize tab $tab",(array)$e);
  die("Failed to initialize tab $tab");
}

try {
  $tab->prepareData($smarty);
} catch(Throwable $e) {
  $logger->error('Failed to read analysis result', (array)$e);
  $smarty->assign('error', 'Failed to read analysis result.');
}

$ajax = getOrDefault('ajax', 0, [0, 1]);
if ($ajax == 1) {
  if (!is_null($tab->getAjaxTemplate()) && $tab->getOutputType() != 'none')
    $smarty->display($tab->getAjaxTemplate());
} elseif ($tab->getOutputType() == 'html')
  $smarty->display($tab->getTemplate());

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

