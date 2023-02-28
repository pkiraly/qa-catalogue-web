<?php


class Network extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('fields', $this->readTags());
  }

  public function getTemplate() {
    return 'network/network.tpl';
  }

  private function readTags() {
    $countFile = $this->getFilePath('network-scores/network-by-concepts-tags.csv');
    $records = readCsv($countFile);
    foreach ($records as $record)
      $this->addImages($record);

    return $records;
  }

  private function addImages(&$record) {
    $record->components_histogram = $this->addImage($record->tag, 'components-histogram');
    $record->components_sorted = $this->addImage($record->tag, 'components-sorted');
    $record->pagerank = $this->addImage($record->tag, 'pagerank-sorted');
    $record->degrees = $this->addImage($record->tag, 'degrees');
  }

  private function addImage($tag, $suffix) {
    $record = (object)[];
    $record->url = sprintf('images/%s/network-scores-%s-%s.png', $this->db, $tag, $suffix);
    $record->exists = file_exists($record->url);

    return $record;
  }

}