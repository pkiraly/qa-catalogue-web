<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:39
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/630.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d7701f2d4_70542932',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8ed9ffbaf2c5545510aff55a3dc23cca8c6701fd' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/630.tpl',
      1 => 1573469324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d7701f2d4_70542932 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'630'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>uniform titles</em>:</td>
  <td>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
      <span class="630">
        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
          <i class="fa fa-hashtag" aria-hidden="true" title="uniform title"></i>
          <a href="#" class="record-link" data="630a_SubjectAddedUniformTitle_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->n)) {?>
          <span class="number-of-part" data="630n_SubjectAddedUniformTitle_numberOfPart_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->n;?>
</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->p)) {?>
          <span class="name-of-part" data="630p_SubjectAddedUniformTitle_nameOfPart_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->p;?>
</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->l)) {?>
          <span class="language" data="630l_SubjectAddedUniformTitle_languageOfAWork_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->l;?>
</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
          <span class="dates" data="630d_SubjectAddedUniformTitle_dateOfTreaty_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->t)) {?>
          <span class="work-title" data="630t_SubjectAddedUniformTitle_titleOfAWork_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->t;?>
</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
          vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
          (authority: <a href="#" class="record-link" data="6300"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
