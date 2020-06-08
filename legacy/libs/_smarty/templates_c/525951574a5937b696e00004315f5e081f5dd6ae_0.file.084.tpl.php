<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/084.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571ea8794_16994244',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '525951574a5937b696e00004315f5e081f5dd6ae' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/084.tpl',
      1 => 1573056972,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571ea8794_16994244 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'084'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>other classifications</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="084">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="084a_Classification_classificationPortion_ss" title="Classification number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <a href="#" class="subdivision" data="084b"
           title="Item number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->q)) {?>
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Assigning agency"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->q;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        <a href="#" class="source" data="0842_Classification_source_ss" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
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
