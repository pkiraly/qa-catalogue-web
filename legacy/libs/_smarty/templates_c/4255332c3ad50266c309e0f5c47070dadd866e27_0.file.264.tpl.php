<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/264.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571ae26b7_58207246',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4255332c3ad50266c309e0f5c47070dadd866e27' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/264.tpl',
      1 => 1573047602,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571ae26b7_58207246 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'264'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="264">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <span class="place"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <span class="name"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <span class="date"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
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
