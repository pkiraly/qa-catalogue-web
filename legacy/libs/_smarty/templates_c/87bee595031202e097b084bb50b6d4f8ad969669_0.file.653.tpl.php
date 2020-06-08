<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:39
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/653.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d7705fc56_15719080',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87bee595031202e097b084bb50b6d4f8ad969669' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/653.tpl',
      1 => 1573469523,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d7705fc56_15719080 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'653'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>uncontrolled terms</em>:</td>
  <td>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
      <span class="653">
        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
          <a href="#" class="record-link" data="653a_UncontrolledIndexTerm_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
        <?php }?>
      </span>
      <br/>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </td>
</tr>
<?php }
}
}
