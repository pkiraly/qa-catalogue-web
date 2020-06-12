<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class ClassificationsController extends BaseContextualController
{
  /**
   * @Route("/classifications")
   */
  public function run() {
    $this->selectTab('classifications');
    return $this->render('classifications/main.html.twig', [
      'commons' => $this->commons,
      'prefix' => 'classification',
      'byRecord' => $this->readByRecords(),
      'byField' => $this->readByField(),
      'has_histogram' => $this->readHistogram()
    ]);
  }

  private function readHistogram() {
    $byRecordsFile = $this->getDir() . '/classifications-histogram.csv';
    if (file_exists($byRecordsFile)) {
      return true; //$smarty->fetch('classifications-histogram.tpl');
    }
    return false;
  }

  private function readByRecords() {
    $count = trim(file_get_contents($this->getDir() . '/count.csv'));
    $byRecordsFile = $this->getDir() . '/classifications-by-records.csv';
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

      return [
        'records' => $records,
        'count' => $count,
        'withClassification' => $withClassification,
        'withoutClassification' => $withoutClassification
      ];
    }
    return NULL;
  }

  private function readByField() {
    $solrFields = $this->getSolrFields();

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
      '600' => 'Subject Added Entry - Personal Name',
      '610' => 'Subject Added Entry - Corporate Name',
      '611' => 'Subject Added Entry - Meeting Name',
      '630' => 'Subject Added Entry - Uniform Title',
      '647' => 'Subject Added Entry - Named Event',
      '648' => 'Subject Added Entry - Chronological Term',
      '650' => 'Subject Added Entry - Topical Term',
      '651' => 'Subject Added Entry - Geographic Name',
      '654' => 'Subject Added Entry - Faceted Topical Terms',
      '655' => 'Index Term - Genre/Form',
      '656' => 'Index Term - Occupation',
      '657' => 'Index Term - Function',
      '658' => 'Index Term - Curriculum Objective',
      '662' => 'Subject Added Entry - Hierarchical Place Name',
      '852' => 'Location',
    ];

    $this->solrFieldMap = $this->getSolrFieldMap();

    $byRecordsFile = $this->getDir() . '/classifications-by-schema.csv';
    if (!file_exists($byRecordsFile)) {
      $byRecordsFile = $this->getDir() . '/classifications-by-field.csv';
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
            $this->createFacets($record, '052a_GeographicClassification');
            $this->ind1Orsubfield2($record, '052ind1_GeographicClassification_codeSource_ss', '0522_GeographicClassification_source_ss');
          } else if ($record->field == '055') {
            $this->createFacets($record, '055a_ClassificationLcc');
            $this->ind2Orsubfield2($record, '055ind2_ClassificationLcc_type_ss', '0552_ClassificationLcc_source_ss');
          } else if ($record->field == '072') {
            $this->createFacets($record, '072a_SubjectCategoryCode');
            $this->ind2Orsubfield2($record, '072ind2_SubjectCategoryCode_codeSource_ss', '0722_SubjectCategoryCode_source_ss');
          } else if ($record->field == '080') {
            $record->facet = $this->createFacets2($record, '080a_Udc_ss');
            $record->q = '*:*';
          } else if ($record->field == '082') {
            $record->facet = $this->createFacets2($record, '082a_ClassificationDdc_ss');
            $record->q = '*:*';
          } else if ($record->field == '083') {
            $record->facet = $this->createFacets2($record, '083a_ClassificationAdditionalDdc_ss');
            $record->q = '*:*';
          } else if ($record->field == '084') {
            $this->createFacets($record, '084a_Classification_classificationPortion');
            $record->q = sprintf('%s:%%22%s%%22', '0842_Classification_source_ss', $record->scheme);
          } else if ($record->field == '085') {
            $record->facet = $this->createFacets2($record, '085b_SynthesizedClassificationNumber_baseNumber_ss');
            $record->q = '*:*';
          } else if ($record->field == '086') {
            $this->createFacets($record, '086a_GovernmentDocumentClassification');
            $this->ind1Orsubfield2($record, '086ind1_GovernmentDocumentClassification_numberSource_ss', '0862_GovernmentDocumentClassification_source_ss');
          } else if ($record->field == '600') {
            $this->createFacets($record, '600a_PersonalNameSubject_personalName');
            $this->ind2Orsubfield2($record, '600ind2_PersonalNameSubject_thesaurus_ss', '6002_PersonalNameSubject_source_ss');
          } else if ($record->field == '610') {
            $this->createFacets($record, '610a_CorporateNameSubject');
            $this->ind2Orsubfield2($record, '610ind2_CorporateNameSubject_thesaurus_ss', '6102_CorporateNameSubject_source_ss');
          } else if ($record->field == '611') {
            $this->createFacets($record, '611a_SubjectAddedMeetingName');
            $this->ind2Orsubfield2($record, '611ind2_SubjectAddedMeetingName_thesaurus_ss', '6112_SubjectAddedMeetingName_source_ss');
          } else if ($record->field == '630') {
            $this->createFacets($record, '630a_SubjectAddedUniformTitle');
            $this->ind2Orsubfield2($record, '630ind2_SubjectAddedUniformTitle_thesaurus_ss', '6302_SubjectAddedUniformTitle_source_ss');
            // TODO: 647
          } else if ($record->field == '648') {
            $this->createFacets($record, '648a_ChronologicalSubject');
            $this->ind2Orsubfield2($record, '648ind2_ChronologicalSubject_thesaurus_ss', '6482_ChronologicalSubject_source_ss');
          } else if ($record->field == '650') {
            $this->createFacets($record, '650a_Topic_topicalTerm');
            $this->ind2Orsubfield2($record, '650ind2_Topic_thesaurus_ss', '6502_Topic_sourceOfHeading_ss');
          } else if ($record->field == '651') {
            $this->createFacets($record, '651a_Geographic');
            $this->ind2Orsubfield2($record, '651ind2_Geographic_thesaurus_ss', '6512_Geographic_source_ss');
          } else if ($record->field == '655') {
            $this->createFacets($record, '655a_GenreForm');
            $this->ind2Orsubfield2($record, '655ind2_GenreForm_thesaurus_ss', '6552_GenreForm_source_ss');
          } else if ($record->field == '852') {
            $this->createFacets($record, '852a_Location_location');
            $this->ind1Orsubfield2($record, '852ind1_852_shelvingScheme_ss', '852__852___ss');
          }

          if (isset($record->facet2) && $record->facet2 != '') {
            $record->facet2exists = in_array($record->facet2, $solrFields);
          }

          if (preg_match('/(^ |  +| $)/', $record->scheme)) {
            $record->scheme = '"' . str_replace(' ', '&nbsp;', $record->scheme) . '"';
          }

          $records[] = $record;
        }
      }
      // id,field,location,scheme,abbreviation,abbreviation4solr,recordcount,instancecount

      $data = [
        'records' => $records,
        'fields' => $fields
      ];
      $data += $this->readSubfields();
      $data += $this->readElements();

      // return $smarty->fetch('classifications-by-field.tpl');
      return $data;
    }
    return NULL;
  }

  private function getSolrFieldMap() {
    $solrFieldMap = [];
    $fields = $this->getSolrFields();
    foreach ($fields as $field) {
      $parts = explode('_', $field);
      $solrFieldMap[$parts[0]] = $field;
    }

    return $solrFieldMap;
  }

  /**
   * @param $record
   * @param $base
   */
  private function createFacets(&$record, $base) {
    $record->facet = $base . '_ss';

    if (isset($record->abbreviation4solr) && $record->abbreviation4solr != '')
      $record->facet2 = $base . '_' . $record->abbreviation4solr . '_ss';
    elseif (isset($record->abbreviation) && $record->abbreviation != '')
      $record->facet2 = $base . '_' . $record->abbreviation . '_ss';
  }

  private function createFacets2(&$record, $default) {
    $key = $record->field . str_replace('$', '', $record->location);
    $facet = isset($this->solrFieldMap[$key])
      ? $this->solrFieldMap[$key]
      : $default;
    return $facet;
  }

  /**
   * @param $dir
   * @param $db
   * @param Smarty $smarty
   * @return object
   */
  private function readSubfields() {
    $data = [];
    $bySubfieldsFile = $this->getDir() . '/classifications-by-schema-subfields.csv';
    if (file_exists($bySubfieldsFile)) {
      $header = [];
      $subfields = [];
      $subfieldsById = [];
      $in = fopen($bySubfieldsFile, "r");
      while (($line = fgets($in)) != false) {
        $values = str_getcsv($line);
        if (empty($header)) {
          $header = $values;
        } else {
          $record = (object)array_combine($header, $values);
          $record->subfields = explode(';', $record->subfields);
          $items = [];
          $hasPlus = FALSE;
          $hasSpace = FALSE;
          foreach ($record->subfields as $subfield) {
            if ($subfield == ' ') {
              $subfield = '_';
              $hasSpace = TRUE;
            }
            $subfield = '$' . $subfield;
            $items[] = $subfield;
            if (preg_match('/\+$/', $subfield)) {
              $hasPlus = TRUE;
              $subfield = str_replace('+', '', $subfield);
            }
            if (!isset($subfieldsById[$record->id]))
              $subfieldsById[$record->id] = [];
            if (!in_array($subfield, $subfieldsById[$record->id]))
              $subfieldsById[$record->id][] = $subfield;
          }
          $record->subfields = $items;
          if (!isset($subfields[$record->id])) {
            $subfields[$record->id] = ['list' => [], 'has-plus' => FALSE, 'has-space' => FALSE];
          }
          $subfields[$record->id]['list'][] = $record;
          if ($hasPlus)
            $subfields[$record->id]['has-plus'] = TRUE;
          if ($hasSpace)
            $subfields[$record->id]['has-space'] = TRUE;

        }
      }
      $data['subfields'] = $subfields;
      $data['hasSubfields'] = TRUE;

      foreach ($subfieldsById as $id => $subfields) {
        sort($subfields);
        $nums = [];
        $alpha = [];
        foreach ($subfields as $subfield) {
          if (preg_match('/\d$/', $subfield)) {
            $nums[] = $subfield;
          } else {
            $alpha[] = $subfield;
          }
        }
        $subfields = array_merge($alpha, $nums);
        $subfieldsById[$id] = $subfields;
      }

      $data['subfieldsById'] = $subfieldsById;
    } else {
      $data['hasSubfields'] = FALSE;
    }

    return $data;
  }

  private function ind1Orsubfield2(&$record, $ind1, $subfield2) {
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

  private function ind2Orsubfield2(&$record, $ind2, $subfield2) {
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
}