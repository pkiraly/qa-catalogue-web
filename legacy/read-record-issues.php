<?php
set_time_limit(0);
require_once 'common-functions.php';

$marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';

$db = getOrDefault('db', 'metadata-qa');
$id = getOrDefault('id', null);
$display = getOrDefault('display', 0);

$configuration = parse_ini_file("configuration.cnf");

// $display = TRUE;
$elementsFile = sprintf('%s/%s/issue-details.csv', $configuration['dir'], $db);
$types = [];
$max = 0;
$issues = [];
if (!file_exists($elementsFile)) {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
} else {
  // $keys = ['recordId', 'MarcPath', 'type', 'message', 'url'];
  $lineNumber = 0;
  $header = [];
  $typeCounter = [];

  $handle = fopen($elementsFile, "r");
  if ($handle) {
    $already_found = false;
    while (($line = fgets($handle)) !== false) {
      // process the line read.
      $lineNumber++;
      $values = str_getcsv($line);
      if ($lineNumber == 1) {
        $header = $values;
      } else {
        if (count($header) != count($values)) {
          error_log('line #' . $lineNumber . ': ' . count($header) . ' vs ' . count($values));
        }
        $record = (object)array_combine($header, $values);
        if ($record->recordId == $id) {
          $errors = [];
          $rawErrors = explode(';', $record->details);
          foreach ($rawErrors as $rawError) {
            list($errorId, $count) = explode(':', $rawError);
            $errors[$errorId] = $count;
          }
          $issueDefinitions = getIssueDefinitions(array_keys($errors));
          foreach ($issueDefinitions as $id => &$issue) {
            $issue->count = $errors[$errorId];
            if (!isset($issues[$issue->type])) {
              $issues[$issue->type] = [];
              $typeCounter[$issue->type] = 0;
            }
            $issues[$issue->type][] = $issue;
            $typeCounter[$issue->type] += $issue->count;
          }
          break;
        }
      }
    }
    fclose($handle);
  }

  $types = array_keys($issues);
}

if ($display == 1) {
  $smarty = createSmarty('templates');
  $smarty->assign('issues', $issues);
  $smarty->assign('types', $types);
  $smarty->assign('fieldNames', ['path', 'message', 'url', 'count']);
  $smarty->assign('typeCounter', $typeCounter);
  $smarty->registerPlugin("function", "showMarcUrl", "showMarcUrl");
  $html = $smarty->fetch('record-issues.tpl');
  echo $html;
} else {
  header("Content-type: application/json");
  echo json_encode([
    'issues' => $issues,
    'types' => $types,
    'typeCounter' => $typeCounter
  ]);
}

function showMarcUrl($content) {
  global $marcBaseUrl;

  if (!preg_match('/^http/', $content))
    $content = $marcBaseUrl . $content;

  return $content;
}

function getIssueDefinitions($ids) {
  global $configuration, $db;

  $issues = [];
  $file = sprintf('%s/%s/issue-summary.csv', $configuration['dir'], $db);
  if (file_exists($file)) {
    $header = [];
    $handle = fopen($file, "r");
    if ($handle) {
      while (($line = fgets($handle)) !== false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
          $header[1] = 'path';
        } else {
          $record = (object)array_combine($header, $values);
          if (in_array($record->id, $ids)) {
            $key = $record->id;
            unset($record->id);
            $issues[$key] = $record;
          }
        }
      }
    }
  }
  return $issues;
}