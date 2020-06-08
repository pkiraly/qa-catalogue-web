<?php
/* Smarty version 3.1.33, created on 2019-11-22 15:10:40
  from '/home/kiru/git/metadata-qa-marc-web/templates/classifications-by-field.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd7ec60727561_30300045',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8b325d9c42c28217b9b8afe124ee00a53ae0e031' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/classifications-by-field.tpl',
      1 => 1574431830,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd7ec60727561_30300045 (Smarty_Internal_Template $_smarty_tpl) {
?><h3>Classification/subject headings schemes</h3>

<table id="classification">
  <thead>
    <tr>
      <th class="location">Location</th>
      <th class="scheme">Classification/subject headings scheme</th>
      <th class="instances">Instances</th>
      <th class="records">Records</th>
    </tr>
  </thead>
  <tbody>
    <?php $_smarty_tpl->_assignInScope('previous', '');?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['records']->value, 'record');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['record']->value) {
?>
      <?php if ($_smarty_tpl->tpl_vars['previous']->value != $_smarty_tpl->tpl_vars['record']->value->field) {?>
        <tr>
          <td colspan="4"><h4><?php echo $_smarty_tpl->tpl_vars['record']->value->field;?>
 &mdash; <?php echo $_smarty_tpl->tpl_vars['fields']->value[$_smarty_tpl->tpl_vars['record']->value->field];?>
</h4></td>
        </tr>
      <?php }?>
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['record']->value->location;?>
</td>
        <td>
          <?php if ((isset($_smarty_tpl->tpl_vars['record']->value->facet2))) {?>
            <?php if ($_smarty_tpl->tpl_vars['record']->value->facet2exists) {?>
              <a href="#" class="term-link facet2" data-facet="<?php echo $_smarty_tpl->tpl_vars['record']->value->facet2;?>
" data-query="*:*" data-scheme="<?php echo $_smarty_tpl->tpl_vars['record']->value->scheme;?>
"><?php echo $_smarty_tpl->tpl_vars['record']->value->scheme;?>
</a>
            <?php } else { ?>
              <?php echo $_smarty_tpl->tpl_vars['record']->value->scheme;?>

            <?php }?>
          <?php } elseif ((isset($_smarty_tpl->tpl_vars['record']->value->facet) && isset($_smarty_tpl->tpl_vars['record']->value->q))) {?>
            <a href="#" class="term-link facet" data-facet="<?php echo $_smarty_tpl->tpl_vars['record']->value->facet;?>
" data-query="<?php echo $_smarty_tpl->tpl_vars['record']->value->q;?>
" data-scheme="<?php echo $_smarty_tpl->tpl_vars['record']->value->scheme;?>
"><?php echo $_smarty_tpl->tpl_vars['record']->value->scheme;?>
</a>
            <?php if (strlen($_smarty_tpl->tpl_vars['record']->value->abbreviation) > 0) {?>(<?php echo $_smarty_tpl->tpl_vars['record']->value->abbreviation;?>
)<?php }?>
          <?php } else { ?>
            <?php echo $_smarty_tpl->tpl_vars['record']->value->scheme;?>

          <?php }?>
          <i class="fa fa-chevron-down"  data-id="classification-subfields-<?php echo $_smarty_tpl->tpl_vars['record']->value->id;?>
" aria-hidden="true" title="show subfields"></i>
          <?php if ($_smarty_tpl->tpl_vars['hasSubfields']->value && isset($_smarty_tpl->tpl_vars['record']->value->id) && isset($_smarty_tpl->tpl_vars['subfields']->value[$_smarty_tpl->tpl_vars['record']->value->id])) {?>
            <div id="classification-subfields-<?php echo $_smarty_tpl->tpl_vars['record']->value->id;?>
" class="classification-subfields">
              <p>Which subfields are available in the individual instances of this field?</p>
              <table>
                <thead>
                  <tr>
                    <th>subfields</th>
                    <th class="count">count</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['subfields']->value[$_smarty_tpl->tpl_vars['record']->value->id]['list'], 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                    <tr>
                      <td>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value->subfields, 'subfield', true);
$_smarty_tpl->tpl_vars['subfield']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['subfield']->value) {
$_smarty_tpl->tpl_vars['subfield']->iteration++;
$_smarty_tpl->tpl_vars['subfield']->last = $_smarty_tpl->tpl_vars['subfield']->iteration === $_smarty_tpl->tpl_vars['subfield']->total;
$__foreach_subfield_2_saved = $_smarty_tpl->tpl_vars['subfield'];
?>
                          <?php ob_start();
echo substr($_smarty_tpl->tpl_vars['subfield']->value,0,2);
$_prefixVariable1 = ob_get_clean();
$_smarty_tpl->_assignInScope('sub', $_prefixVariable1);?>
                          <a href="#completeness-<?php echo $_smarty_tpl->tpl_vars['record']->value->field;
echo $_smarty_tpl->tpl_vars['sub']->value;?>
" class="completeness" data-field="<?php echo $_smarty_tpl->tpl_vars['record']->value->field;
echo $_smarty_tpl->tpl_vars['sub']->value;?>
"
                          ><?php echo $_smarty_tpl->tpl_vars['subfield']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['subfield']->last) {?>, <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['subfield'] = $__foreach_subfield_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                      </td>
                      <td class="count"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['item']->value->count ));?>
</td>
                    </tr>
                  <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </tbody>
              </table>
              <p>notes:</p>
              <ul>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['subfieldsById']->value[$_smarty_tpl->tpl_vars['record']->value->id], 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                  <?php $_smarty_tpl->_assignInScope('key', ((string)$_smarty_tpl->tpl_vars['record']->value->field).((string)$_smarty_tpl->tpl_vars['item']->value));?>
                  <li>
                    <a href="#completeness-<?php echo $_smarty_tpl->tpl_vars['record']->value->field;
echo $_smarty_tpl->tpl_vars['item']->value;?>
" class="completeness" data-field="<?php echo $_smarty_tpl->tpl_vars['record']->value->field;
echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</a>:
                    <?php if (isset($_smarty_tpl->tpl_vars['elements']->value[$_smarty_tpl->tpl_vars['key']->value]) && $_smarty_tpl->tpl_vars['elements']->value[$_smarty_tpl->tpl_vars['key']->value] != '') {?>
                      <?php echo $_smarty_tpl->tpl_vars['elements']->value[$_smarty_tpl->tpl_vars['key']->value];?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value == '$9') {?>
                      &mdash; <span>(locally defined subfield)</span>
                    <?php } else { ?>
                      &mdash; <span>(not defined in MARC21)</span>
                    <?php }?>
                  </li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </ul>
              <?php if ($_smarty_tpl->tpl_vars['subfields']->value[$_smarty_tpl->tpl_vars['record']->value->id]['has-plus'] || $_smarty_tpl->tpl_vars['subfields']->value[$_smarty_tpl->tpl_vars['record']->value->id]['has-space']) {?>
                <ul>
                  <?php if ($_smarty_tpl->tpl_vars['subfields']->value[$_smarty_tpl->tpl_vars['record']->value->id]['has-plus']) {?>
                    <li>+ sign denotes multiple instances</li>
                  <?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['subfields']->value[$_smarty_tpl->tpl_vars['record']->value->id]['has-space']) {?>
                    <li>_ sign denotes space character</li>
                  <?php }?>
                </ul>
              <?php }?>
            </div>
          <?php }?>
        </td>
        <td class="text-right"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->instancecount ));?>
</td>
        <td class="text-right"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'number_format' ][ 0 ], array( $_smarty_tpl->tpl_vars['record']->value->recordcount ));?>
</td>
      </tr>
      <?php $_smarty_tpl->_assignInScope('previous', $_smarty_tpl->tpl_vars['record']->value->field);?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </tbody>
</table>

<?php echo '<script'; ?>
>
// $()
$('table#classification i').click(function (event) {
  event.preventDefault();
  var id = '#' + $(this).attr('data-id');
  $(id).toggle();
  var up = 'fa-chevron-up';
  var down = 'fa-chevron-down';
  if ($(this).hasClass(down)) {
    $(this).removeClass(down);
    $(this).addClass(up);
  } else {
    $(this).removeClass(up);
    $(this).addClass(down);
  }
});
$('a.completeness').click(function () {
  showTab('completeness');
  setCompletenessLinkHandlers();
});
<?php echo '</script'; ?>
><?php }
}
