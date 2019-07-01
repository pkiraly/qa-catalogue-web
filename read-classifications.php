<?php
require_once 'common-functions.php';
$smarty = createSmarty('templates');

$db = getOrDefault('db', 'cerl');
$configuration = parse_ini_file("configuration.cnf");
$countFile = sprintf('%s/%s/count.csv', $configuration['dir'], $db);

$result = new stdClass();
$result->byRecord = readByRecords($configuration['dir'], $db);
$result->byField = readByField($configuration['dir'], $db);

header('Content-Type: application/json');
echo json_encode($result);

function readByRecords($dir, $db) {
  global $smarty, $countFile;

  $count = trim(file_get_contents($countFile));
  $byRecordsFile = sprintf('%s/%s/classifications-by-records.csv', $dir, $db);
  if (file_exists($byRecordsFile)) {
    $header = [];
    $records = [];
    $withClassification = NULL;
    $withoutClassification = NULL;
    $in = fopen($byRecordsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        $record = (object)array_combine($header, $values);
        $record->percent = $record->count / $count;
        $records[] = $record;
        if ($record->{'records-with-classification'} === 'true') {
          $withClassification = $record;
        } else {
          $withoutClassification = $record;
        }
      }
    }

    $smarty->assign('records', $records);
    $smarty->assign('count', $count);
    $smarty->assign('withClassification', $withClassification);
    $smarty->assign('withoutClassification', $withoutClassification);

    return $smarty->fetch('classifications-by-records.tpl');
  }
  return NULL;
}

function readByField($dir, $db) {
  global $smarty;

  $fields = [
    '052' => 'Geographic Classification',
    '055' => 'Classification Numbers Assigned in Canada',
    '072' => 'Subject Category Code',
    '080' => 'Universal Decimal Classification Number',
    '082' => 'Dewey Decimal Classification Number',
    '083' => 'Additional Dewey Decimal Classification Number',
    '084' => 'Other Classification Number',
    '085' => 'Synthesized Classification Number Components',
    '086' => 'Government Document Classification Number',
    '600' => 'Subject Added Entry-Personal Name',
    '610' => 'Subject Added Entry-Corporate Name',
    '611' => 'Subject Added Entry-Meeting Name',
    '630' => 'Subject Added Entry-Uniform Title',
    '647' => 'Subject Added Entry-Named Event',
    '648' => 'Subject Added Entry-Chronological Term',
    '650' => 'Subject Added Entry-Topical Term',
    '651' => 'Subject Added Entry-Geographic Name',
    '655' => 'Index Term-Genre/Form',
    '852' => 'Location',
  ];

  $byRecordsFile = sprintf('%s/%s/classifications-by-schema.csv', $dir, $db);
  if (!file_exists($byRecordsFile)) {
    $byRecordsFile = sprintf('%s/%s/classifications-by-field.csv', $dir, $db);
  }
  if (file_exists($byRecordsFile)) {
    $header = [];
    $records = [];
    $in = fopen($byRecordsFile, "r");
    while (($line = fgets($in)) != false) {
      $values = str_getcsv($line);
      if (empty($header)) {
        $header = $values;
      } else {
        $record = (object)array_combine($header, $values);
        if (!isset($record->field))
          error_log('empty? ' . $line);
        if ($record->field == '052') {
          $record->facet = '052a_GeographicClassification_ss';
          ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
        } else if ($record->field == '055') {
          $record->facet = '055a_ClassificationLcc_ss';
          ind2Orsubfield2($record, '055ind2_ClassificationLcc_type_ss', '0552_ClassificationLcc_source_ss');
        } else if ($record->field == '072') {
          $record->facet = '072a_SubjectCategoryCode_ss';
          ind2Orsubfield2($record, '072ind2_SubjectCategoryCode_codeSource_ss', '0722_SubjectCategoryCode_source_ss');
        } else if ($record->field == '080') {
          $record->facet = '080a_Udc_ss';
          $record->q = '*:*';
        } else if ($record->field == '082') {
          $record->facet = '082a_ClassificationDdc_ss';
          $record->q = '*:*';
        } else if ($record->field == '083') {
          $record->facet = '083a_ClassificationAdditionalDdc_ss';
          $record->q = '*:*';
        } else if ($record->field == '084') {
          $record->facet = '084a_Classification_classificationPortion_ss';
          $record->q = sprintf('%s:%%22%s%%22', '0842_Classification_source_ss', $record->scheme);
        // TODO: 085
        } else if ($record->field == '086') {
          $record->facet = '086a_GovernmentDocumentClassification_ss';
          ind1Orsubfield2($record, '086ind1_GovernmentDocumentClassification_numberSource_ss', '0862_GovernmentDocumentClassification_source_ss');
        } else if ($record->field == '600') {
          $record->facet = '600a_PersonalNameSubject_personalName_ss';
          ind2Orsubfield2($record, '600ind2_PersonalNameSubject_thesaurus_ss', '6002_PersonalNameSubject_source_ss');
        } else if ($record->field == '610') {
          $record->facet = '610a_CorporateNameSubject_ss';
          ind2Orsubfield2($record, '610ind2_CorporateNameSubject_thesaurus_ss', '6102_CorporateNameSubject_source_ss');
        } else if ($record->field == '611') {
          $record->facet = '611a_SubjectAddedMeetingName_ss';
          ind2Orsubfield2($record, '611ind2_SubjectAddedMeetingName_thesaurus_ss', '6112_SubjectAddedMeetingName_source_ss');
        } else if ($record->field == '630') {
          $record->facet = '630a_SubjectAddedUniformTitle_ss';
          ind2Orsubfield2($record, '630ind2_SubjectAddedUniformTitle_thesaurus_ss', '6302_SubjectAddedUniformTitle_source_ss');
        // TODO: 647
        } else if ($record->field == '648') {
          $record->facet = '648a_ChronologicalSubject_ss';
          ind2Orsubfield2($record, '648ind2_ChronologicalSubject_thesaurus_ss', '6482_ChronologicalSubject_source_ss');
        } else if ($record->field == '650') {
          $record->facet = '650a_Topic_topicalTerm_ss';
          ind2Orsubfield2($record, '650ind2_Topic_thesaurus_ss', '6502_Topic_sourceOfHeading_ss');
        } else if ($record->field == '651') {
          $record->facet = '651a_Geographic_ss';
          ind2Orsubfield2($record, '651ind2_Geographic_thesaurus_ss', '6512_Geographic_source_ss');
        } else if ($record->field == '655') {
          $record->facet = '655a_GenreForm_ss';
          ind2Orsubfield2($record, '655ind2_GenreForm_thesaurus_ss', '6552_GenreForm_source_ss');
        } else if ($record->field == '852') {
          $record->facet = '852a_852_location_ss';
          ind1Orsubfield2($record, '852ind1_852_shelvingScheme_ss', '852__852___ss');
        }

        $records[] = $record;
      }
    }

    $smarty->assign('records', $records);
    $smarty->assign('fields', $fields);
    return $smarty->fetch('classifications-by-field.tpl');
  }
  return NULL;
}

function ind1Orsubfield2(&$record, $ind1, $subfield2) {
  $debug = ($record->field == '052');
  if ($debug)
    error_log('location: ' . $record->location);
  if ($record->location == 'ind1') {
    $record->q = sprintf('%s:%%22%s%%22', $ind1, $record->scheme);
  } else if ($record->location == '$2') {
    if ($record->scheme == 'undetectable') {
      $record->q = sprintf('%s:%%22Source specified in subfield \$2%%22 NOT %s:*', $ind1, $subfield2);
    } else {
      $record->q = sprintf('%s:%%22%s%%22', $subfield2, $record->scheme);
    }
  }
  if ($debug)
    error_log('q: ' . $record->q);
}

function ind2Orsubfield2(&$record, $ind2, $subfield2) {
  if ($record->location == 'ind2') {
    $record->q = sprintf('%s:%%22%s%%22', $ind2, $record->scheme);
  } else if ($record->location == '$2') {
    if ($record->scheme == 'undetectable') {
      $record->q = sprintf('%s:%%22Source specified in subfield \$2%%22 NOT %s:*', $ind2, $subfield2);
    } else {
      $record->q = sprintf('%s:%%22%s%%22', $subfield2, $record->scheme);
    }
  }
}

