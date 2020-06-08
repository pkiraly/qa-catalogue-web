<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:10
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/650.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc925720ab911_35941296',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c109e77849fadd23f5147e94ab2ddc59c1ea30c0' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/650.tpl',
      1 => 1573052951,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc925720ab911_35941296 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'650'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>topics</em>:</td>
  <td>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
              <span class="650">
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
            <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
            <a href="#" class="record-link" data="650a_Topic_topicalTerm_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
          <?php }?>

                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->z)) {?>
            geo:
            <i class="fa fa-map" aria-hidden="true" title="geographic subdivision"></i>
            <a href="#" class="record-link" data="650z_Topic_geographicSubdivision_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->z;?>
</a>
          <?php }?>

                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->v)) {?>
            form:
            <i class="fa fa-tag" aria-hidden="true" title="form"></i>
            <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->v;?>
</a>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'2'})) {?>
            vocabulary: <?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'2'};?>
</a>
          <?php }?>

                    <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
            (authority: <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
