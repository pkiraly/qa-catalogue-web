<?php

function getOrDefault($key, $default_value = NULL, $allowed_values = []) {
  $value = isset($_GET[$key]) ? $_GET[$key] : $default_value;
  if (!isset($value)
    || (!empty($allowed_values) && !in_array($value, $allowed_values))) {
    $value = $default_value;
  }
  return $value;
}

function getPostedOrDefault($key, $default_value = NULL, $allowed_values = []) {
  $value = isset($_POST[$key]) ? $_POST[$key] : $default_value;
  if (!isset($value)
    || (!empty($allowed_values) && !in_array($value, $allowed_values))) {
    $value = $default_value;
  }
  return $value;
}

function createSmarty($templateDir) {
  define('APPLICATION', 'szte');
  define('APPLICATION_DIR', $_SERVER['DOCUMENT_ROOT'] . '/' . APPLICATION);
  define('SMARTY_DIR', APPLICATION_DIR . '/libs/smarty-3.1.33/libs/');
  define('_SMARTY', APPLICATION_DIR . '/libs/_smarty/');
  require_once(SMARTY_DIR . 'Smarty.class.php');
  $smarty = new Smarty();
  $smarty->setTemplateDir(getcwd() . '/' . $templateDir);
  $smarty->setCompileDir(_SMARTY . '/templates_c/');
  $smarty->setConfigDir(_SMARTY . '/configs/');
  $smarty->setCacheDir(_SMARTY . '/cache/');
  $smarty->addPluginsDir(APPLICATION_DIR . '/common/smarty_plugins/');
  // standard PHP function
  $smarty->registerPlugin("modifier", "str_replace", "str_replace");
  $smarty->registerPlugin("modifier", "number_format", "number_format");
  return $smarty;
}
