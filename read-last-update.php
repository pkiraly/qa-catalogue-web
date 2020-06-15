<?php

require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'metadata-qa');
$configuration = parse_ini_file("configuration.cnf");

$file = sprintf('%s/%s/last-update.csv', $configuration['dir'], $db);
$lastUpdate = trim(file_get_contents($file));

header("Content-type: application/json");
echo json_encode([
  'lastUpdate' => $lastUpdate,
]);
