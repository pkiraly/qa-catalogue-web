<?php


interface Tab {

  public function prepareData(&$smarty);
  public function getTemplate();

}