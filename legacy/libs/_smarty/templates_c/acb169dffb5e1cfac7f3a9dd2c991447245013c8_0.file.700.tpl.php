<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/700.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571ca2844_38849010',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'acb169dffb5e1cfac7f3a9dd2c991447245013c8' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/700.tpl',
      1 => 1573050798,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571ca2844_38849010 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'700'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>additional personal names</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="700">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <a href="#" class="record-link" data="700a_AddedPersonalName_personalName_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <span class="numeration"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <span class="titles"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
        <span class="dates"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->e)) {?>
        <span class="relator"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->e;?>
</span>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        (authority: <a href="#" class="record-link" data="7000"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
</a>)
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
