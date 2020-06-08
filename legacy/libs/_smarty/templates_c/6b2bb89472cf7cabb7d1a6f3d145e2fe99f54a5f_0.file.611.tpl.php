<?php
/* Smarty version 3.1.33, created on 2019-11-11 11:52:38
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/611.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc93d76f2ac39_49791444',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6b2bb89472cf7cabb7d1a6f3d145e2fe99f54a5f' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/611.tpl',
      1 => 1573469213,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc93d76f2ac39_49791444 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'611'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>meetings</em>:</td>
  <td>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
      <span class="611">
                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
            <i class="fa fa-hashtag" aria-hidden="true" title="meeting name"></i>
            <a href="#" class="record-link" data="611a_SubjectAddedMeetingName_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
            <span class="numeration" data="611b_SubjectAddedMeetingName_b_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
            <span class="location" data="611c_SubjectAddedMeetingName_locationOfMeeting_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
            <span class="dates" data="611d_SubjectAddedMeetingName_dates_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
            vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
          <?php }?>

                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
            (authority: <a href="#" class="record-link" data="6110"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
