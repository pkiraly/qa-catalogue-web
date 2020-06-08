<?php
/* Smarty version 3.1.33, created on 2019-11-08 18:05:29
  from '/home/kiru/git/metadata-qa-marc-web/templates/authorities-by-records.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc5a059790f65_00750743',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd3089a2605159db043536c252a7ef76751d468cf' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/authorities-by-records.tpl',
      1 => 1573232723,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc5a059790f65_00750743 (Smarty_Internal_Template $_smarty_tpl) {
?><h3>records with authority names</h3>

<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">with</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">without</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: <?php echo ceil($_smarty_tpl->tpl_vars['withClassification']->value->percent*500);?>
px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['withClassification']->value->count,0 ));?>

    (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( ($_smarty_tpl->tpl_vars['withClassification']->value->percent*100),2 ));?>
%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['withoutClassification']->value->count,0 ));?>

    (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( ($_smarty_tpl->tpl_vars['withoutClassification']->value->percent*100),2 ));?>
%)
  </div>
</div>
<?php }
}
