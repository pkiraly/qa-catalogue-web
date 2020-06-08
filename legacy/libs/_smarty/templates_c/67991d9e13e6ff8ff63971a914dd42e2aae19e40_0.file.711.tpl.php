<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/711.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571d0fef0_43582265',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '67991d9e13e6ff8ff63971a914dd42e2aae19e40' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/711.tpl',
      1 => 1573050237,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571d0fef0_43582265 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'711'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>additional meeting names</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="711">
      <i class="fa fa-user" aria-hidden="true" title="Meeting name or jurisdiction name as entry element"></i>
      <a href="#" class="record-link" data="711a_AddedMeetingName_ss" title="Meeting name or jurisdiction name as entry element"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <span class="location" title="Location of meeting"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
        <span class="dates" title="Date of meeting"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->e)) {?>
        <span class="unit" title="Subordinate unit"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->e;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->f)) {?>
        <span class="misc" title="Date of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->f;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->g)) {?>
        <span class="misc" title="Miscellaneous information"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->g;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->j)) {?>
        <span class="dates" title="Relator term"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->j;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->n)) {?>
        <span class="dates" title="Number of part/section/meeting"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->n;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->t)) {?>
        <span class="part" title="Title of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->t;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        <span class="part" title="Authority record control number or standard number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
</span>
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
