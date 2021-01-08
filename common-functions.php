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

function getPath() {
  $parsed_url = parse_url($_SERVER['REQUEST_URI']);
  $path = preg_replace(',\/,', '', $parsed_url['path']);
  return $path;
}

function createSmarty($templateDir) {
  // define('APPLICATION', 'szte');
  // define('APPLICATION_DIR', $_SERVER['DOCUMENT_ROOT'] . '/' . APPLICATION);
  define('APPLICATION_DIR', __DIR__);
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

function readCsv($csvFile, $id = '') {
  $records = [];
  if (file_exists($csvFile)) {
    $lineNumber = 0;
    $header = [];

    foreach (file($csvFile) as $line) {
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
  } else {
    error_log('file does not exist! ' . $csvFile);
  }
  return $records;
}