<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:39
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/655.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d7707b625_85947858',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64d727af644542027578158675007fd3f63f9a0c' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/655.tpl',
      1 => 1573469440,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d7707b625_85947858 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'655'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>genres</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="655">
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <a href="#" class="record-link" data="655a_GenreForm_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->v)) {?>
        form: <span class="form"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->v;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'}) || isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>[
        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
          vocabulary: <span class="source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
          <a href="#" class="record-link" data="6550_GenreForm_authorityRecordControlNumber_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
</a>
        <?php }?>
      ]<?php }?>
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
