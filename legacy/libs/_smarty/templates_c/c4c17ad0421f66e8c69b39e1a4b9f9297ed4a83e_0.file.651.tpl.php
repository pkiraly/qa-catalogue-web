<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:39
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/651.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d7704a9d0_12663113',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4c17ad0421f66e8c69b39e1a4b9f9297ed4a83e' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/651.tpl',
      1 => 1573469476,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d7704a9d0_12663113 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'651'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>geographic names</em>:</td>
  <td>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
      <span class="651">
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
            <i class="fa fa-map" aria-hidden="true" title="geographic term"></i>
            <a href="#" class="record-link" data="651a_Geographic_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
            vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
            (authority: <a href="#" class="record-link" data="6510_Geographic_authorityRecordControlNumber_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
