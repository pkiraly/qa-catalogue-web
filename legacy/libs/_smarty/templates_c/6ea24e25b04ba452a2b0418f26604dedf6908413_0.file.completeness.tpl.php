<?php
/* Smarty version 3.1.33, created on 2019-11-23 18:47:00
  from '/home/kiru/git/metadata-qa-marc-web/templates/completeness.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd970941aa772_40735784',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ea24e25b04ba452a2b0418f26604dedf6908413' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/completeness.tpl',
      1 => 1574531217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd970941aa772_40735784 (Smarty_Internal_Template $_smarty_tpl) {
?><table>
  <colgroup>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col style="border-right: 1px solid #cccccc;">
    <col>
    <col>
    <col>
    <col>
    <col>
  </colgroup>
  <thead>
    <tr class="first">
      <th colspan="3"></th>
      <th></th>
      <th colspan="2" class="with-border">records</th>
      <th colspan="5" class="with-border">occurences</th>
    </tr>
    <tr class="second">
      <th class="left path">path</th>
      <th class="left subfield">label</th>
      <th class="left chart"></th>
      <th class="terms">terms</th>
      <th class="number-of-record">count</th>
      <th class="percent-of-record">%</th>
      <th class="number-of-instances">count</th>
      <th class="min">min</th>
      <th class="max">max</th>
      <th class="mean">mean</th>
      <th class="stddev">stddev</th>
    </tr>
  </thead>
  <tbody>
    <?php $_smarty_tpl->_assignInScope('previousPackage', '');?>
    <?php $_smarty_tpl->_assignInScope('previousTag', '');?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'record');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
?>
      <?php if ($_smarty_tpl->tpl_vars['previousPackage']->value != $_smarty_tpl->tpl_vars['record']->value->package) {?>
        <tr>
          <td colspan="4" class="package"><?php echo $_smarty_tpl->tpl_vars['record']->value->package;?>
</td>
        </tr>
        <?php $_smarty_tpl->_assignInScope('previousPackage', ((string)$_smarty_tpl->tpl_vars['record']->value->package));?>
      <?php }?>
      <?php if ($_smarty_tpl->tpl_vars['previousTag']->value != $_smarty_tpl->tpl_vars['record']->value->tag) {?>
        <tr>
          <td colspan="4" class="tag"><?php echo substr($_smarty_tpl->tpl_vars['record']->value->path,0,3);?>
 &mdash; <?php echo $_smarty_tpl->tpl_vars['record']->value->tag;?>
</td>
        </tr>
        <?php $_smarty_tpl->_assignInScope('previousTag', ((string)$_smarty_tpl->tpl_vars['record']->value->tag));?>
      <?php }?>
      <?php $_smarty_tpl->_assignInScope('percent', ((string)($_smarty_tpl->tpl_vars['record']->value->{'number-of-record'}*100/$_smarty_tpl->tpl_vars['max']->value)));?>
      <tr>
        <td class="path" id="completeness-<?php echo $_smarty_tpl->tpl_vars['record']->value->path;?>
">
          <?php if (isset($_smarty_tpl->tpl_vars['record']->value->solr)) {?>
            <a href="javascript:searchForField('<?php echo $_smarty_tpl->tpl_vars['record']->value->solr;?>
')"><?php echo substr($_smarty_tpl->tpl_vars['record']->value->path,3);?>
</a>
          <?php } else { ?>
            <?php echo substr($_smarty_tpl->tpl_vars['record']->value->path,3);?>

          <?php }?>
        </td>
        <td class="subfield"><?php echo $_smarty_tpl->tpl_vars['record']->value->subfield;?>
</td>
        <td class="chart"><div style="width: <?php echo ceil($_smarty_tpl->tpl_vars['percent']->value*2);?>
px;">&nbsp;</div></td>
        <td class="terms">
          <?php if (isset($_smarty_tpl->tpl_vars['record']->value->solr)) {?>
            <a href="#" class="term-link facet2" data-facet="<?php echo $_smarty_tpl->tpl_vars['record']->value->solr;?>
" data-query="*:*"
               data-scheme="<?php echo $_smarty_tpl->tpl_vars['record']->value->solr;?>
"><i class="fa fa-list-ol"></i></a>
          <?php }?>
        </td>
        <td class="number-of-record"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->{'number-of-record'} ));?>
</td>
        <td class="percent-of-record"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['percent']->value,2 ));?>
%</td>
        <td class="number-of-instances"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->{'number-of-instances'} ));?>
</td>
        <td class="min"><?php echo $_smarty_tpl->tpl_vars['record']->value->min;?>
</td>
        <td class="max"><?php echo $_smarty_tpl->tpl_vars['record']->value->max;?>
</td>
        <td class="mean"><?php echo $_smarty_tpl->tpl_vars['record']->value->mean;?>
</td>
        <td class="stddev"><?php echo $_smarty_tpl->tpl_vars['record']->value->stddev;?>
</td>
      </tr>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </tbody>
</table>
<?php }
}
