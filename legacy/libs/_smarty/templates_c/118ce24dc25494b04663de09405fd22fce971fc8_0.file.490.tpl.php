<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/490.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571b2b361_13344771',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '118ce24dc25494b04663de09405fd22fce971fc8' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/490.tpl',
      1 => 1573125309,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571b2b361_13344771 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'490'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
  Series:
  <ul>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <li>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value->subfields->a, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_2_saved = $_smarty_tpl->tpl_vars['value'];
?>
          <a href="#" class="record-link tag-490a" data="490a_SeriesStatement_ss"
          title="Series statement"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->l)) {?>
        <span class="subarea" data="490l"
         title="Library of Congress call number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->l;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->v)) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value->subfields->v, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_3_saved = $_smarty_tpl->tpl_vars['value'];
?>
          <a href="#" class="record-link subarea" data="490v_SeriesStatement_volume_ss"
         title="Volume/sequential designation"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_3_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->x)) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value->subfields->x, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_4_saved = $_smarty_tpl->tpl_vars['value'];
?>
          <span class="issn" data="490x"
           title="International Standard Serial Number"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</span><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_4_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'3'})) {?>
        <a href="#" class="record-link issn" data="4903_SeriesStatement_materialsSpecified_ss"
         title="Materials specified"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'3'};?>
</a>
      <?php }?>
    </li>
  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </ul>
<?php }
}
}
