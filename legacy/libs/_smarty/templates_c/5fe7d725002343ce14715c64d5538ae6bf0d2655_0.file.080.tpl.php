<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/080.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571e31ae7_41245499',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5fe7d725002343ce14715c64d5538ae6bf0d2655' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/080.tpl',
      1 => 1573126394,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571e31ae7_41245499 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'080'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>Universal Decimal Classification</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="080">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="udc"></i>
        <a href="#" class="record-link" data="080a_Udc_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <a href="#" class="record-link item-number" data="080b_Udc_number_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</a>
      <?php }?>

      
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->x)) {?>
        <a href="#" class="common-auxiliary-subdivision" data="080x_Udc_commonAuxiliarySubdivision_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->x;?>
</a>
      <?php }?>

            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        <a href="#" class="edition" data="0802_Udc_edition_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['field']->value->ind1 == '0') {?>Full<?php }?>
      <?php if ($_smarty_tpl->tpl_vars['field']->value->ind1 == '1') {?>Abridged<?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        <a href="#" class="edition" data="0800_Udc_0_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
