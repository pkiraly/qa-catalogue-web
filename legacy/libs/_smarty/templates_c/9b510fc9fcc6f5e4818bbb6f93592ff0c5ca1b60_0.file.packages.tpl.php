<?php
/* Smarty version 3.1.33, created on 2020-04-02 16:18:09
  from '/home/kiru/git/metadata-qa-marc-web/templates/packages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5e85f421052779_56461923',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b510fc9fcc6f5e4818bbb6f93592ff0c5ca1b60' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/packages.tpl',
      1 => 1575478987,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e85f421052779_56461923 (Smarty_Internal_Template $_smarty_tpl) {
?><table>
  <thead>
    <tr>
      <th>tags</th>
      <th>label</th>
      <th></th>
      <th class="text-right">count</th>
      <th class="text-right">percent</th>
    </tr>
  </thead>
  <tbody>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'record');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
?>
      <?php if (!isset($_smarty_tpl->tpl_vars['record']->value->iscoretag) || $_smarty_tpl->tpl_vars['record']->value->iscoretag) {?>
        <tr>
          <td><?php echo $_smarty_tpl->tpl_vars['record']->value->name;?>
</td>
          <td><?php if (($_smarty_tpl->tpl_vars['record']->value->label != 'null')) {
echo $_smarty_tpl->tpl_vars['record']->value->label;
}?></td>
          <td class="chart"><div style="width: <?php echo ceil($_smarty_tpl->tpl_vars['record']->value->percent*2);?>
px;">&nbsp;</div></td>
          <td class="text-right"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->count ));?>
</td>
          <td class="text-right"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->percent,2 ));?>
%</td>
        </tr>
      <?php }?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php if ($_smarty_tpl->tpl_vars['hasNonCoreTags']->value) {?>
      <tr>
        <td colspan="5"><h4>Fields defined in extensions of MARC</h4></td>
      </tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'record');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
?>
        <?php if (isset($_smarty_tpl->tpl_vars['record']->value->iscoretag) && !$_smarty_tpl->tpl_vars['record']->value->iscoretag) {?>
          <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['record']->value->name;?>
</td>
            <td><?php if (($_smarty_tpl->tpl_vars['record']->value->label != 'null')) {
echo $_smarty_tpl->tpl_vars['record']->value->label;
}?></td>
            <td class="chart"><div style="width: <?php echo ceil($_smarty_tpl->tpl_vars['record']->value->percent*2);?>
px;">&nbsp;</div></td>
            <td class="text-right"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->count ));?>
</td>
            <td class="text-right"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->percent,2 ));?>
%</td>
          </tr>
        <?php }?>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
  </tbody>
</table>
<?php }
}
