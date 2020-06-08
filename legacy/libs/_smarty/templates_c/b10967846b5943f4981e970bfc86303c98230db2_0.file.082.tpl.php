<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/082.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571e4f895_18846729',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b10967846b5943f4981e970bfc86303c98230db2' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/082.tpl',
      1 => 1573054890,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571e4f895_18846729 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'082'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>Dewey Decimal Classification</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="082">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="082a_ClassificationDdc_ss" title="Classification number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <a href="#" class="subdivision" data="082b_ClassificationDdc_itemPortion_ss" title="Subject category code subdivision"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->m)) {?>
        <span class="designation" data="072x" title="Standard or optional designation"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->m;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->q)) {?>
        <span class="agency" data="082q_ClassificationDdc_source_ss" title="Assigning agency"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->q;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        <a href="#" class="source" data="0822_ClassificationDdc_edition_ss" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
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
