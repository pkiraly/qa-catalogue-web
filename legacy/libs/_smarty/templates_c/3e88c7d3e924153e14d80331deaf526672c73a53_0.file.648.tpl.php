<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:10
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/648.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92572094001_02507437',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3e88c7d3e924153e14d80331deaf526672c73a53' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/648.tpl',
      1 => 1573052983,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92572094001_02507437 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'648'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
  <tr>
    <td><em>chronological terms</em>:</td>
    <td>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <span class="648">
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
            <i class="fa fa-hashtag" aria-hidden="true" title="Chronological term"></i>
            <a href="#" class="record-link" data="648a_ChronologicalSubject_ss" title="Chronological term"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->v)) {?>
            <span class="dates" title="Form subdivision"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->v;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->x)) {?>
            <span class="work-title" title="General subdivision"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->x;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->y)) {?>
            <span class="work-title" title="Chronological subdivision"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->y;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->z)) {?>
            <span class="work-title" title="Geographic subdivision"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->z;?>
</span>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'}) || isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>[
                        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
              vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
            <?php }?>

            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
              (ID: <a href="#" class="record-link" data="6470"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
</a>)
            <?php }?>
          ]<?php }?>
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
