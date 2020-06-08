<?php
/* Smarty version 3.1.33, created on 2019-11-01 18:11:49
  from '/home/kiru/git/metadata-qa-marc-web/templates/conditional-foreach.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dbc6755704a02_70015590',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '57a48eca3ed4ed62422889d5d983cc524e32ae98' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/conditional-foreach.tpl',
      1 => 1572627892,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dbc6755704a02_70015590 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['obj']->value) && isset($_smarty_tpl->tpl_vars['key']->value) && isset($_smarty_tpl->tpl_vars['obj']->value->{$_smarty_tpl->tpl_vars['key']->value}))) {?>
  <?php $_smarty_tpl->_assignInScope('var', $_smarty_tpl->tpl_vars['obj']->value->{$_smarty_tpl->tpl_vars['key']->value});
}
if (isset($_smarty_tpl->tpl_vars['var']->value)) {?>
  <?php if (isset($_smarty_tpl->tpl_vars['label']->value)) {
echo $_smarty_tpl->tpl_vars['label']->value;
}?>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['var']->value, 'value');
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->first = !$_smarty_tpl->tpl_vars['value']->index;
$__foreach_value_15_saved = $_smarty_tpl->tpl_vars['value'];
?>
    <?php if (isset($_smarty_tpl->tpl_vars['tag']->value)) {?>
        <?php if (gettype($_smarty_tpl->tpl_vars['tag']->value) != 'string') {
echo json_encode($_smarty_tpl->tpl_vars['tag']->value);
}?>
      <span class="tag-<?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</span><?php if (!$_smarty_tpl->tpl_vars['value']->first) {?>, <?php }?>
    <?php } else { ?>
      <?php echo $_smarty_tpl->tpl_vars['value']->value;
if (!$_smarty_tpl->tpl_vars['value']->first) {?>, <?php }?>
    <?php }?>
  <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_15_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <?php if (isset($_smarty_tpl->tpl_vars['suffix']->value)) {
echo $_smarty_tpl->tpl_vars['suffix']->value;
}
}
}
}
