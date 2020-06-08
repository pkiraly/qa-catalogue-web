<?php
/* Smarty version 3.1.33, created on 2019-11-22 14:47:12
  from '/home/kiru/git/metadata-qa-marc-web/templates/record-issues.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd7e6e09ff8f7_29993851',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c7b469fee89d8bf976c36f9dfb93a1254f379f1' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/record-issues.tpl',
      1 => 1574430313,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd7e6e09ff8f7_29993851 (Smarty_Internal_Template $_smarty_tpl) {
if (count($_smarty_tpl->tpl_vars['issues']->value) == 0) {?>
<p>The tool has not detected any issues in this record</p>
<?php } else { ?>
<table id="issues-table">
  <thead>
    <tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldNames']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <th class="<?php echo $_smarty_tpl->tpl_vars['field']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['field']->value == 'message') {?>value/explanation<?php } else {
echo $_smarty_tpl->tpl_vars['field']->value;
}?></th>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </tr>
  </thead>
  <tbody>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['types']->value, 'type', false, NULL, 'types', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index']++;
?>
      <tr class="type-header <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
        <td colspan="3" class="type"><span class="type"><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</span> (<?php echo count($_smarty_tpl->tpl_vars['issues']->value[$_smarty_tpl->tpl_vars['type']->value]);?>
 variant(s))
        <td class="count"><?php echo $_smarty_tpl->tpl_vars['typeCounter']->value[$_smarty_tpl->tpl_vars['type']->value];?>
</td>
      </tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['issues']->value[$_smarty_tpl->tpl_vars['type']->value], 'rowData', false, NULL, 'foo', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['rowData']->value) {
?>
        <tr class="t-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index'] : null);?>
">
          <td class="path"><?php echo $_smarty_tpl->tpl_vars['rowData']->value->path;?>
</td>
          <td class="message">
            <?php if (preg_match('/^ +$/',$_smarty_tpl->tpl_vars['rowData']->value->message)) {?>"<?php echo $_smarty_tpl->tpl_vars['rowData']->value->message;?>
"<?php } else {
echo $_smarty_tpl->tpl_vars['rowData']->value->message;
}?>
          </td>
          <td class="url">
            <a href="<?php echo showMarcUrl($_smarty_tpl->tpl_vars['rowData']->value->url);?>
" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
          </td>
          <td class="count"><?php echo $_smarty_tpl->tpl_vars['rowData']->value->count;?>
</td>
        </tr>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </tbody>
</table>
<?php }
}
}
