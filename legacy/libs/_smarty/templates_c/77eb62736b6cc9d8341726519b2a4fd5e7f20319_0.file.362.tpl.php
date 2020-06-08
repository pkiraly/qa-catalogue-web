<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/362.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571b51682_26303765',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '77eb62736b6cc9d8341726519b2a4fd5e7f20319' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/362.tpl',
      1 => 1573046201,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571b51682_26303765 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'362'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
  <em>Dates of Publication</em><br>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="362">
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <span class="dates"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</span>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->z)) {?>
        <span class="source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->z;?>
</span>
      <?php }?>
    </span>
    <br/>
  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
}
