<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/052.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571dc0517_84726100',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '488708c9c69a26e87e4ed117ed2878eda2afc107' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/052.tpl',
      1 => 1573123100,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571dc0517_84726100 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'052'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>geographic classification</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="052">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <i class="fa fa-hashtag" aria-hidden="true" title="Geographic classification area code"></i>
        <a href="#" class="area" data="052a"
           title="Geographic classification area code"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <a href="#" class="subarea" data="052b"
           title="Geographic classification subarea code"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
        <a href="#" class="place-name" data="052d"
           title="Populated place name"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
        <a href="#" class="source" data="0522" title="Source"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
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
