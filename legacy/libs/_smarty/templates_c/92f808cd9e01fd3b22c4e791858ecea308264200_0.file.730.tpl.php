<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/730.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571d90da8_13543111',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '92f808cd9e01fd3b22c4e791858ecea308264200' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/730.tpl',
      1 => 1573050775,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571d90da8_13543111 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'730'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>uniform title</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="730">
      <i class="fa fa-user" aria-hidden="true" title="Uniform title"></i>
      <a href="#" class="record-link" data="730a_AddedUniformTitle_ss" title="Uniform title"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
        <span class="date" title="Date of treaty signing"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
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
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->i)) {?>
        <span class="form" title="Relationship information"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->i;?>
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
      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->x)) {?>
        <span class="version" title="International Standard Serial Number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->x;?>
</span>
      <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        [<a href="#" class="record-link" data="7300_AddedUniformTitle_authorityRecordControlNumber_ss">
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
