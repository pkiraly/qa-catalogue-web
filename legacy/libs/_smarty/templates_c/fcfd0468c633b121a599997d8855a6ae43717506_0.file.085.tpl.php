<?php
/* Smarty version 3.1.33, created on 2019-11-11 10:10:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/085.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc92571edd2a7_28496873',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fcfd0468c633b121a599997d8855a6ae43717506' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/085.tpl',
      1 => 1573122175,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dc92571edd2a7_28496873 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'085'));
if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
<tr>
  <td><em>synthesized classifications</em>:</td>
  <td>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
    <span class="085">
            <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
        <a href="#" class="record-link" data="084a_Classification_classificationPortion_ss"
           title="Number where instructions are found-single number or beginning number of span"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
        <a href="#" class="subdivision" data="085b_SynthesizedClassificationNumber_baseNumber_ss"
           title="Base number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</a>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->c)) {?>
        <span class="subdivision" data="084b"
           title="Classification number-ending number of span"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->c;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->f)) {?>
        <span class="subdivision" data="084b"
           title="Facet designator"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->f;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->r)) {?>
        <span class="root-number" data="084b"
           title="Root number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->r;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->s)) {?>
        <span class="agency" data="085s_SynthesizedClassificationNumber_fromClassification_ss"
              title="Digits added from classification number in schedule or external table"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->s;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->t)) {?>
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Digits added from internal subarrangement or add table"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->t;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->u)) {?>
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Number being analyzed"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->u;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->v)) {?>
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Number in internal subarrangement or add table where instructions are found"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->v;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->w)) {?>
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Table identification-Internal subarrangement or add table"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->w;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->y)) {?>
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Table sequence number for internal subarrangement or add table"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->y;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->z)) {?>
        <span class="agency" data="085z_SynthesizedClassificationNumber_tableIdentification_ss"
              title="Table identification"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->z;?>
</span>
      <?php }?>

      <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->{'0'})) {?>
        <a href="#" class="source" data="0842_Classification_source_ss"
           title="Authority record control number or standard number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->{'0'};?>
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
