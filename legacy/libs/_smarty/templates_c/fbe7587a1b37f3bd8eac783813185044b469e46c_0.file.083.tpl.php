<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/083.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571e7d9b3_27118994',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbe7587a1b37f3bd8eac783813185044b469e46c' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/083.tpl',
      1 => 1573055547,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571e7d9b3_27118994 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'083'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>additional DDC</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="083">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="083a_ClassificationAdditionalDdc_ss" title="Classification number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <a href="#" class="subdivision" data="083c" title="Classification number--Ending number of span"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->m)) {?>
        <span class="designation" data="083m"
              title="Standard or optional designation"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->m;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->q)) {?>
        <span class="agency" data="083q_ClassificationAdditionalDdc_source_ss"
              title="Assigning agency"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->q;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->y)) {?>
        <span class="table-sequence-number" data="083y"
              title="Table sequence number for internal subarrangement or add table"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->y;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->z)) {?>
        <span class="table-id" data="083z"
              title="Table identification"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->z;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        <a href="#" class="source" data="0832_ClassificationAdditionalDdc_edition_ss" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
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
