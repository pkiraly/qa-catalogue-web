<?php
/* Smarty version 3.1.33, created on 2019-11-23 21:28:02
  from '/home/kiru/git/metadata-qa-marc-web/templates/issue-summary.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd99652086180_26735548',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c2d48abb7b607bde6daa63c52472cb1993148cb' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/issue-summary.tpl',
      1 => 1574540791,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd99652086180_26735548 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">records without issues</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">with</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: <?php echo ceil($_smarty_tpl->tpl_vars['topStatistics']->value[0]->percent*5);?>
px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['topStatistics']->value[0]->records,0 ));?>

    (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['topStatistics']->value[0]->percent,2 ));?>
%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['topStatistics']->value[1]->records,0 ));?>

    (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['topStatistics']->value[1]->percent,2 ));?>
%)
  </div>
</div>

<p>excluding undefined field issues</p>
<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">records without issues</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">with</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: <?php echo ceil((100-$_smarty_tpl->tpl_vars['topStatistics']->value[2]->percent)*5);?>
px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['total']->value-$_smarty_tpl->tpl_vars['topStatistics']->value[2]->records,0 ));?>

    (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( (100-$_smarty_tpl->tpl_vars['topStatistics']->value[2]->percent),2 ));?>
%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['topStatistics']->value[2]->records,0 ));?>

    (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['topStatistics']->value[2]->percent,2 ));?>
%)
  </div>
</div>

<table id="issues-table">
  <thead>
    <tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldNames']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <th <?php if (in_array($_smarty_tpl->tpl_vars['field']->value,array('instances','records'))) {?>class="text-right"<?php }?>><?php if ('field' == 'message') {?>value/explanation<?php } else {
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'types', false, 'category', 'categories', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value => $_smarty_tpl->tpl_vars['types']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['index']++;
?>
    <tr class="category-header <?php echo $_smarty_tpl->tpl_vars['category']->value;?>
">
      <td colspan="3" class="category">
        <span class="category"><?php echo $_smarty_tpl->tpl_vars['category']->value;?>
</span> level issues
      </td>
      <td class="count"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['categoryStatistics']->value[$_smarty_tpl->tpl_vars['category']->value]->instances ));?>
</td>
      <td class="count"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['categoryStatistics']->value[$_smarty_tpl->tpl_vars['category']->value]->records ));?>
</td>
    </tr>
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
        <td colspan="3" class="type">
          <span class="type"><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</span> (<?php echo $_smarty_tpl->tpl_vars['typeCounter']->value[$_smarty_tpl->tpl_vars['type']->value]->variations;?>
 variants)
          <a href="javascript:openType('<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['index'] : null);?>
-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index'] : null);?>
')">[+]</a>
        </td>
        <td class="count"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['typeStatistics']->value[$_smarty_tpl->tpl_vars['type']->value]->instances ));?>
</td>
        <td class="count"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['typeStatistics']->value[$_smarty_tpl->tpl_vars['type']->value]->records ));?>
</td>
      </tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value[$_smarty_tpl->tpl_vars['type']->value], 'rowData', false, NULL, 'foo', array (
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['rowData']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_foo']->value['index']++;
?>
        <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_foo']->value['index'] : null) < 100) {?>
          <tr class="t t-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_categories']->value['index'] : null);?>
-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index'] : null);?>
 <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_foo']->value['index'] : null)%2 == 1) {?>odd<?php }?>">
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
            <td class="count instances">
              <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['rowData']->value->id;?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" data-path="<?php echo $_smarty_tpl->tpl_vars['rowData']->value->path;?>
"
                 data-message="<?php echo $_smarty_tpl->tpl_vars['rowData']->value->message;?>
"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['rowData']->value->instances ));?>
</a>
            </td>
            <td class="count records">
              <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['rowData']->value->id;?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" data-path="<?php echo $_smarty_tpl->tpl_vars['rowData']->value->path;?>
"
                 data-message="<?php echo $_smarty_tpl->tpl_vars['rowData']->value->message;?>
"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['rowData']->value->records ));?>
</a>
            </td>
          </tr>
        <?php }?>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php if ($_smarty_tpl->tpl_vars['typeCounter']->value[$_smarty_tpl->tpl_vars['type']->value]->variations > 100) {?>
        <tr class="t t-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_types']->value['index'] : null);?>
 text-centered <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
          <td colspan="4">more</td>
        </tr>
      <?php }?>
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
