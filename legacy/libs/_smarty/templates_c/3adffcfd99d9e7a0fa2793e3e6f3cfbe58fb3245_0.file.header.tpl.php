<?php
/* Smarty version 3.1.33, created on 2019-11-04 14:09:38
  from '/home/kiru/git/metadata-qa-marc-web/templates/parts/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc02312be9f83_37058810',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3adffcfd99d9e7a0fa2793e3e6f3cfbe58fb3245' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/parts/header.tpl',
      1 => 1572872353,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc02312be9f83_37058810 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>QA catalogue for analysing library data</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <!-- script src="//use.fontawesome.com/feff23b961.js"><?php echo '</script'; ?>
 -->
  <?php echo '<script'; ?>
 src="feff23b961.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="//code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"><?php echo '</script'; ?>
>
  <link rel="stylesheet" href="metadata-qa.css">
  <?php echo '<script'; ?>
 type="text/javascript">
      var db = 'cerl';
      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('db')) {
          db = urlParams.get('db');
      } else {
          db = window.location.pathname.replace(/\//g, '');
      }
      var marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
      var solrProxy = 'solr-proxy.php';
      var solrDisplay = 'solr-display.php';

      function showMarcUrl(link) {
          return marcBaseUrl + link;
      }
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="configuration.js" type="text/javascript"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="loadFacets.php" type="text/javascript"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://d3js.org/d3.v5.min.js"><?php echo '</script'; ?>
>
</head><?php }
}
