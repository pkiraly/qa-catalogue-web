<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:38
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/610.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d76f08bf0_74962080',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ba776b0f41dc9812bc12572268e756d0ea949b9' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/610.tpl',
      1 => 1573469151,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d76f08bf0_74962080 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'610'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>corporate names</em>:</td>
  <td>
  <em>Corporate names as subjects</em><br>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
      <span class="600">
                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
            <i class="fa fa-hashtag" aria-hidden="true" title="corporate"></i>
            <a href="#" class="record-link" data="610a_CorporateNameSubject_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
            <span class="numeration" data="610b_CorporateNameSubject_subordinateUnit_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
            <span class="titles" data="610c_CorporateNameSubject_locationOfMeeting_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
            <span class="dates" data="610d_CorporateNameSubject_dates_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
            vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
          <?php }?>

                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
            (authority: <a href="#" class="record-link" data="6100"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
