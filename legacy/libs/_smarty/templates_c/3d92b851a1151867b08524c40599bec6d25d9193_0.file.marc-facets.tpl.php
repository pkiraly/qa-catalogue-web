<?php
/* Smarty version 3.1.33, created on 2019-11-18 16:55:48
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc-facets.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd2bf0439aee7_16156232',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3d92b851a1151867b08524c40599bec6d25d9193' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc-facets.tpl',
      1 => 1574092523,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd2bf0439aee7_16156232 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['facets']->value, 'values', false, 'facetName');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['facetName']->value => $_smarty_tpl->tpl_vars['values']->value) {
?>
  <div id="<?php echo $_smarty_tpl->tpl_vars['facetName']->value;?>
" class="facet-block">
    <h4><?php echo getFacetLabel($_smarty_tpl->tpl_vars['facetName']->value);?>
</h4>
    <?php $_smarty_tpl->_assignInScope('offsetName', "f.".((string)$_smarty_tpl->tpl_vars['facetName']->value).".facet.offset");?>
    <?php if (isset($_smarty_tpl->tpl_vars['params']->value->{$_smarty_tpl->tpl_vars['offsetName']->value})) {?>
      <?php $_smarty_tpl->_assignInScope('offset', ((string)$_smarty_tpl->tpl_vars['params']->value->{$_smarty_tpl->tpl_vars['offsetName']->value}));?>
    <?php } else { ?>
      <?php $_smarty_tpl->_assignInScope('offset', 0);?>
    <?php }?>
    <ul>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['values']->value, 'count', false, 'term');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['term']->value => $_smarty_tpl->tpl_vars['count']->value) {
?>
        <li><a href="#" class="facet-term"><?php echo $_smarty_tpl->tpl_vars['term']->value;?>
</a> (<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['count']->value ));?>
)</li>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php if (count(get_object_vars($_smarty_tpl->tpl_vars['values']->value)) >= 10 || $_smarty_tpl->tpl_vars['offset']->value > 0) {?>
        <li>
          <?php if ($_smarty_tpl->tpl_vars['offset']->value > 0) {?>
            <a class="facet-up" href="#" data-field="<?php echo $_smarty_tpl->tpl_vars['facetName']->value;?>
" data-offset="<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
">
              <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
            </a>
          <?php }?>
          more
          <?php if (count(get_object_vars($_smarty_tpl->tpl_vars['values']->value)) >= 10) {?>
            <a class="facet-down" href="#" data-field="<?php echo $_smarty_tpl->tpl_vars['facetName']->value;?>
" data-offset="<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
">
              <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
            </a>
          <?php }?>
        </li>
      <?php }?>
    </ul>
  </div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
