<?php

/**
 * Class for creating the record diff tab
 */
class RecordDiff extends BaseTab {

  protected $recordId;
  protected $parameterFile = 'validation.params.json';

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    parent::readAnalysisParameters();
    $smarty->assign('analysisTimestamp', $this->analysisParameters->analysisTimestamp);
    $smarty->assign('showRecordDiff', !is_null($this->configuration->getRecordApiForDiff()));


    $this->recordId = getOrDefault('recordId', '');
    $this->schema = getOrDefault('schema', '', ['MARC21', 'PICA']);

    $solrParams = [sprintf('q=id:"%s"', $this->recordId)];
    $response = $this->solr()->getSolrResponse($solrParams);
    foreach ($response->docs as $doc) {
      $record = new Record($doc, $this->configuration, $this->catalogue, $this->log);
      break;
    }

    $smarty->assign('record', $record);
    $smarty->assign('diff', $record->diff($this->schema));
  }

  public function getTemplate() {
    return 'data/pica/diff-view.tpl';
  }

  public function getAjaxTemplate() {
    return 'data/pica/diff-view.tpl';
  }
}