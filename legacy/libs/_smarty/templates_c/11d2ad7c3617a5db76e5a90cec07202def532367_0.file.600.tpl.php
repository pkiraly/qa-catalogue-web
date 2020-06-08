<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:38
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/600.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d76e69bd2_43411190',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '11d2ad7c3617a5db76e5a90cec07202def532367' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/600.tpl',
      1 => 1573469106,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d76e69bd2_43411190 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'600'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>personal names</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="600">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Personal name"></i>
        <a href="#" class="record-link" data="600a_PersonalNameSubject_personalName_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <span class="numeration" data="600b_PersonalNameSubject_numeration_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
      <?php }?>

            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <span class="titles" data="600c_PersonalNameSubject_titlesAndWords_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
      <?php }?>

            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
        <span class="dates" data="600d_PersonalNameSubject_dates_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
      <?php }?>

            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        (authority: <a href="#" class="record-link" data="6000_PersonalNameSubject_authorityRecordControlNumber_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
