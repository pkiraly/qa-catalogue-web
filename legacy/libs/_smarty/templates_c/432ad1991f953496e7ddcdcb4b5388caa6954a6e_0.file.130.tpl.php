<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/130.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571c69dc5_18904250',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '432ad1991f953496e7ddcdcb4b5388caa6954a6e' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/130.tpl',
      1 => 1573050837,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571c69dc5_18904250 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'130'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>uniform title</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="130">
      <i class="fa fa-user" aria-hidden="true" title="title"></i>
      <a href="#" class="record-link" data="130a_MainUniformTitle_ss" title="Uniform title"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <span class="date" title="Date of treaty signing"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
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
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->h)) {?>
        <span class="medium" title="Medium"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->h;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->k)) {?>
        <span class="form" title="Form subheading"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->k;?>
</span>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->l)) {?>
        <span class="form" title="Language of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->l;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->m)) {?>
        <span class="medium" title="Medium of performance for music"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->m;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->n)) {?>
        <span class="part" title="Number of part/section of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->n;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->o)) {?>
        <span class="statement" title="Arranged statement for music"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->o;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->p)) {?>
        <span class="part-name" title="Name of part/section of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->p;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->r)) {?>
        <span class="key" title="Key for music"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->r;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->s)) {?>
        <span class="version" title="Version"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->s;?>
</span>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->t)) {?>
        <span class="version" title="Title of a work"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->t;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        [<a href="#" class="record-link" data="1300_MainUniformTitle_authorityRecordControlNumber_ss">
        <span class="version" title="Authority record control number or standard number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
</span></a>]
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
