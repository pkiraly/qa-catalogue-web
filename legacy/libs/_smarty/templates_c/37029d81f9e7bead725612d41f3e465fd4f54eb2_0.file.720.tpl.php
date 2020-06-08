<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/720.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571d47c78_68896088',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37029d81f9e7bead725612d41f3e465fd4f54eb2' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/720.tpl',
      1 => 1573050767,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571d47c78_68896088 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'720'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>uncontrolled name</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="720">
      <i class="fa fa-user" aria-hidden="true" title="Name"></i>
      <a href="#" class="record-link" data="720a" title="Name"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->e)) {?>
        <span class="date" title="Relator term"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->e;?>
</span>
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
