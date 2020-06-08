<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/072.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571de8846_19739579',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '51b2f23ca28d36e8e39d2b0139a64f51ffa38222' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/072.tpl',
      1 => 1573054432,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571de8846_19739579 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'072'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>subject category code</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="072">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Subject category code"></i>
        <a href="#" class="record-link" data="072a_SubjectCategoryCode_ss" title="Subject category code"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->x)) {?>
        <a href="#" class="common-auxiliary-subdivision" data="072x" title="Subject category code subdivision"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->x;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        <a href="#" class="source" data="0722" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
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
