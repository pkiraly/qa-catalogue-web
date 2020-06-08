<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/086.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571ef5e64_69490901',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7fc245dc1306bf14338885f57ab655866b1148b' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/086.tpl',
      1 => 1573057325,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571ef5e64_69490901 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'086'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>government document classifications</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="086">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="086a_GovernmentDocumentClassification_ss" title="Classification number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->z)) {?>
        <a href="#" class="cancelled" data="086z"
           title="Canceled/invalid classification number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->z;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->ind1) && $_smarty_tpl->tpl_vars['field']->value->ind1 != ' ') {?>
        <a href="#" class="source" data="086ind1_GovernmentDocumentClassification_numberSource_ss" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->ind1;?>
</a>
      <?php } else { ?>
        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
          <a href="#" class="source" data="0862_GovernmentDocumentClassification_source_ss" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
        <?php }?>
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
