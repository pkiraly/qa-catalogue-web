<?php

function getOrDefault($key, $default_value = NULL, $allowed_values = []) {
  $value = isset($_GET[$key]) ? $_GET[$key] : $default_value;
  if (!isset($value)
    || (!empty($allowed_values) && !in_array($value, $allowed_values))) {
    $value = $default_value;
  }
  return $value;
}
