<?php
$db = preg_replace('/^\/(.*?)\/.*$/', '$1', $_SERVER["PHP_SELF"]);
$file = 'cache/selected-facets-' . $db . '.js';
if (file_exists($file)) {
  $facets = file_get_contents('cache/selected-facets-' . $db . '.js');
} else {
  $facets = file_get_contents('cache/selected-facets.js');
}

header("Content-type: text/javascript");
echo $facets;