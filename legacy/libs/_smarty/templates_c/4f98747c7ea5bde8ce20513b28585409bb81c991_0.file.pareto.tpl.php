<?php
/* Smarty version 3.1.33, created on 2020-04-02 21:30:26
  from '/home/kiru/git/metadata-qa-marc-web/templates/pareto.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5e863d5209f407_57422985',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4f98747c7ea5bde8ce20513b28585409bb81c991' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/pareto.tpl',
      1 => 1585840535,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e863d5209f407_57422985 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['files']->value, 'file', false, 'index');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['index']->value => $_smarty_tpl->tpl_vars['file']->value) {
?>
  <p><img src="images/<?php echo $_smarty_tpl->tpl_vars['db']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['file']->value;?>
" width="1000"/></p>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
