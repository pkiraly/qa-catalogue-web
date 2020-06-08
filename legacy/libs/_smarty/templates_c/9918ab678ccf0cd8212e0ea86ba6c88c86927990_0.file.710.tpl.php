<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/710.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571ce5e12_69606358',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9918ab678ccf0cd8212e0ea86ba6c88c86927990' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/710.tpl',
      1 => 1573051519,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571ce5e12_69606358 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'710'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>additional corporate names</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="710">
      <a href="#" class="record-link" data="710a_AddedCorporateName_ss" title="Corporate name or jurisdiction name as entry element"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <span class="unit" title="Subordinate unit"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <span class="location" title="Location of meeting"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
        <span class="dates" title="Date of meeting or treaty signing"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->e)) {?>
        <span class="relator" title="Relator term"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->e;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->f)) {?>
        <span class="date-of-a-work" title="Date of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->f;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->g)) {?>
        <span class="misc" title="Miscellaneous information"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->g;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->n)) {?>
        <span class="relator" title="Number of part/section/meeting"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->n;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->p)) {?>
        <span class="relator" title="Name of part/section of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->p;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->t)) {?>
        <span class="relator" title="Title of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->t;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        <span class="relator" title="Authority record control number or standard number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
