<?php


interface Tab {

  public function prepareData(Smarty &$smarty);
  public function getTemplate();

}