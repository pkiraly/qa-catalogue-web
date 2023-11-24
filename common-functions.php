<?php

/**
 * @param $key The URL key
 * @param null $default_value A default value in case it is missing
 * @param array $allowed_values A list of allowed values
 * @return mixed|null
 */
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
  define('APPLICATION_DIR', __DIR__);
  define('_SMARTY', APPLICATION_DIR . '/_smarty/');
  $smarty = new Smarty();
  $smarty->setTemplateDir(getcwd() . '/' . $templateDir);
  $smarty->setCompileDir(_SMARTY . '/templates_c/');
  $smarty->setConfigDir(_SMARTY . '/configs/');
  $smarty->setCacheDir(_SMARTY . '/cache/');
  $smarty->addPluginsDir(APPLICATION_DIR . '/common/smarty_plugins/');
  // standard PHP function
  $smarty->registerPlugin("modifier", "str_replace", "str_replace");
  $smarty->registerPlugin("modifier", "number_format", "number_format");
  $smarty->registerPlugin("function", "_t", "_t");
  return $smarty;
}

function readCsv($csvFile, $id = '') {
  $records = [];
  if (file_exists($csvFile)) {
    $lineNumber = 0;
    $header = [];

    $handle = fopen($csvFile, "r");
    if ($handle) {
      while (($line = fgets($handle)) !== false) {
        $lineNumber++;
        $values = str_getcsv($line);
        if ($lineNumber == 1) {
          $header = $values;
        } else {
          if (count($header) != count($values)) {
            error_log(sprintf('error in %s line #%d: %d vs %d', $csvFile, $lineNumber, count($header), count($values)));
          }
          $record = (object)array_combine($header, $values);
          if ($id != '' && isset($record->{$id})) {
            $records[$record->{$id}] = $record;
          } else {
            $records[] = $record;
          }
        }
      }
    }
  } else {
    error_log('file does not exist! ' . $csvFile);
  }
  return $records;
}

function setLanguage($language) {
  global $languages;
  $lang = isset($languages[$language]) ? $languages[$language] : $languages['en'];
  // putenv('LANG=' . $lang);
  setlocale(LC_ALL, $lang);
  bindtextdomain('messages', './locale');
  textdomain('messages');
}

if (!function_exists('array_is_list')) {
  function array_is_list(array $arr) {
    if ($arr === [])
      return true;
    return array_keys($arr) === range(0, count($arr) - 1);
  }
}

/**
 * Translate string with variables
 * @return mixed|string The first argument should be the msgid, the rest should be the variables to inject
 */
function _t() {
  $args = func_get_args();
  $args[0] = _($args[0]);

  if(func_num_args() <= 1)
    return $args[0];

  return call_user_func_array('sprintf', $args);
}

