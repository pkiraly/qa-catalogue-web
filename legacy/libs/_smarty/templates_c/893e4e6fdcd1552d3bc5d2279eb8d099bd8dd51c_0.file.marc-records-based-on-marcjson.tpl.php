<?php
/* Smarty version 3.1.33, created on 2019-11-19 17:37:53
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc-records-based-on-marcjson.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd41a61023961_64049831',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '893e4e6fdcd1552d3bc5d2279eb8d099bd8dd51c' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc-records-based-on-marcjson.tpl',
      1 => 1574181467,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:conditional-foreach.tpl' => 14,
    'file:marc/264.tpl' => 1,
    'file:marc/490.tpl' => 1,
    'file:marc/362.tpl' => 1,
    'file:marc/100.tpl' => 1,
    'file:marc/110.tpl' => 1,
    'file:marc/111.tpl' => 1,
    'file:marc/130.tpl' => 1,
    'file:marc/700.tpl' => 1,
    'file:marc/710.tpl' => 1,
    'file:marc/711.tpl' => 1,
    'file:marc/720.tpl' => 1,
    'file:marc/730.tpl' => 1,
    'file:marc/052.tpl' => 1,
    'file:marc/072.tpl' => 1,
    'file:marc/080.tpl' => 1,
    'file:marc/082.tpl' => 1,
    'file:marc/083.tpl' => 1,
    'file:marc/084.tpl' => 1,
    'file:marc/085.tpl' => 1,
    'file:marc/086.tpl' => 1,
    'file:marc/600.tpl' => 1,
    'file:marc/610.tpl' => 1,
    'file:marc/611.tpl' => 1,
    'file:marc/630.tpl' => 1,
    'file:marc/647.tpl' => 1,
    'file:marc/648.tpl' => 1,
    'file:marc/650.tpl' => 1,
    'file:marc/651.tpl' => 1,
    'file:marc/653.tpl' => 1,
    'file:marc/655.tpl' => 1,
    'file:marc/leader.tpl' => 1,
    'file:marc/008.tpl' => 1,
  ),
),false)) {
function content_5dd41a61023961_64049831 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/szte/libs/smarty-3.1.33/libs/plugins/modifier.regex_replace.php','function'=>'smarty_modifier_regex_replace',),));
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['docs']->value, 'doc');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['doc']->value) {
?>
  <?php $_smarty_tpl->_assignInScope('record', getRecord($_smarty_tpl->tpl_vars['doc']->value));?>
  <?php $_smarty_tpl->_assignInScope('id', smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['doc']->value->id,"/ +"."$"."/",''));?>
  <?php $_smarty_tpl->_assignInScope('type', getFirstField($_smarty_tpl->tpl_vars['doc']->value,'type_ss'));?>
  <div class="record">
    <h2>
      <?php $_smarty_tpl->_assignInScope('tag245', getField($_smarty_tpl->tpl_vars['record']->value,'245'));?>
      <?php $_smarty_tpl->_assignInScope('tag773', getField($_smarty_tpl->tpl_vars['record']->value,'773'));?>
      <i class="fa fa-<?php echo type2icon($_smarty_tpl->tpl_vars['type']->value);?>
" title="type: <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"></i>
      <?php if (isset($_smarty_tpl->tpl_vars['tag245']->value->subfields->a) || isset($_smarty_tpl->tpl_vars['tag245']->value->subfields->b)) {?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag245']->value->subfields,'key'=>'a'), 0, true);
?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag245']->value->subfields,'key'=>'b'), 0, true);
?>
      <?php } elseif (isset($_smarty_tpl->tpl_vars['tag773']->value)) {?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag773']->value->subfields,'key'=>'t'), 0, true);
?>
        <?php if (isset($_smarty_tpl->tpl_vars['tag245']->value->subfields->n)) {?>
          <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag245']->value->subfields,'key'=>'n'), 0, true);
?>
        <?php }?>
      <?php }?>
      <a href="#" class="record-details" data="details-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" title="display details"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
      <a href="<?php echo opacLink($_smarty_tpl->tpl_vars['doc']->value,$_smarty_tpl->tpl_vars['doc']->value->id);?>
" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>
        <?php if (isset($_smarty_tpl->tpl_vars['tag245']->value->subfields->c)) {?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag245']->value->subfields,'key'=>'c','label'=>'<i class="fa fa-pencil" aria-hidden="true"></i>','suffix'=>'<br/>'), 0, true);
?>
        <?php } elseif (isset($_smarty_tpl->tpl_vars['tag773']->value->subfields->a)) {?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag773']->value->subfields,'key'=>'a','label'=>'<i class="fa fa-pencil" aria-hidden="true"></i>','suffix'=>'<br/>'), 0, true);
?>
    <?php }?>

        <?php $_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'250'));?>
    <?php if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
          <span class="250a_Edition_editionStatement_ss"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</span>
        <?php }?>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (hasPublication($_smarty_tpl->tpl_vars['doc']->value)) {?>
            <?php $_smarty_tpl->_assignInScope('tag260', getField($_smarty_tpl->tpl_vars['record']->value,'260'));?>
      <i class="fa fa-calendar" aria-hidden="true"></i>
      Published
            <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag260']->value->subfields,'key'=>'a','label'=>'in','tag'=>'260a'), 0, true);
?>
            <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag260']->value->subfields,'key'=>'b','label'=>'by','tag'=>'260b'), 0, true);
?>
            <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag260']->value->subfields,'key'=>'c','label'=>'in','tag'=>'260c'), 0, true);
?>
      <br/>
    <?php }?>

    <?php $_smarty_tpl->_subTemplateRender('file:marc/264.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

    <?php if (hasPhysicalDescription($_smarty_tpl->tpl_vars['doc']->value)) {?>
      <?php $_smarty_tpl->_assignInScope('tag300', getField($_smarty_tpl->tpl_vars['record']->value,'300'));?>
            <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag300']->value->subfields,'key'=>'a','tag'=>'300a'), 0, true);
?>
            <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag300']->value->subfields,'key'=>'b','tag'=>'300b'), 0, true);
?>
            <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['tag300']->value->subfields,'key'=>'c','tag'=>'300c'), 0, true);
?>
      <br/>
    <?php }?>

        <?php $_smarty_tpl->_subTemplateRender('file:marc/490.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

        <?php $_smarty_tpl->_subTemplateRender('file:marc/362.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

        <?php $_smarty_tpl->_assignInScope('tag520s', getFields($_smarty_tpl->tpl_vars['record']->value,'520'));?>
    <?php if (!is_null($_smarty_tpl->tpl_vars['tag520s']->value)) {?>
      <!-- 520a_Summary_ss -->
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tag520s']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['field']->value->subfields,'key'=>'a','suffix'=>'<br/>'), 0, true);
?>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>

        <?php $_smarty_tpl->_assignInScope('tag505s', getFields($_smarty_tpl->tpl_vars['record']->value,'505'));?>
    <?php if (!is_null($_smarty_tpl->tpl_vars['tag505s']->value)) {?>
      <!-- 505a_TableOfContents_ss -->
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tag505s']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['field']->value->subfields,'key'=>'a','suffix'=>'<br/>'), 0, true);
?>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>

        <?php $_smarty_tpl->_assignInScope('fieldInstances', getFields($_smarty_tpl->tpl_vars['record']->value,'773'));?>
    <?php if (!is_null($_smarty_tpl->tpl_vars['fieldInstances']->value)) {?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fieldInstances']->value, 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
        <span class="773">
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->a)) {?>
            <span class="main-entry"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->a;?>
</span>
          <?php }?>
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->b)) {?>
            <span class="edition"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->b;?>
</span>
          <?php }?>
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->d)) {?>
            <span class="place-publisher-dates"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->d;?>
</span>
          <?php }?>
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->t)) {?>
            <span class="title"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->t;?>
</span>
          <?php }?>
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->x)) {?>
            <span class="issn"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->x;?>
</span>
          <?php }?>
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->g)) {?>
            <span class="related-parts"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->g;?>
</span>
          <?php }?>
          <?php if (isset($_smarty_tpl->tpl_vars['field']->value->subfields->w)) {?>
            <span class="record-control-number"><?php echo $_smarty_tpl->tpl_vars['field']->value->subfields->w;?>
</span>
          <?php }?>
        </span>
        <br/>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>

    <?php if (hasAuthorityNames($_smarty_tpl->tpl_vars['record']->value) || hasSubjectHeadings($_smarty_tpl->tpl_vars['record']->value)) {?>
      <table class="authority-names">
      <?php if (hasAuthorityNames($_smarty_tpl->tpl_vars['record']->value)) {?>
        <tr><td colspan="2" class="heading">Authority names</td></tr>
                        <?php $_smarty_tpl->_subTemplateRender('file:marc/100.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/110.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/111.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/130.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/700.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/710.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/711.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/720.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/730.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
      <?php }?>

      <?php if (hasSubjectHeadings($_smarty_tpl->tpl_vars['record']->value)) {?>
        <tr><td colspan="2" class="heading">Subjects</td></tr>
                        <?php $_smarty_tpl->_subTemplateRender('file:marc/052.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/072.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/080.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/082.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/083.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/084.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/085.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/086.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/600.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/610.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/611.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/630.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/647.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/648.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/650.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/651.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/653.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php $_smarty_tpl->_subTemplateRender('file:marc/655.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
      <?php }?>
      </table>
    <?php }?>

    <?php if (hasSimilarBooks($_smarty_tpl->tpl_vars['doc']->value)) {?>
      <div class="similarity">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search for similar items:
        <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'9129_WorkIdentifier_ss'})) {?>
          works:
          <a href="#" class="record-link" data="9129_WorkIdentifier_ss"><?php echo $_smarty_tpl->tpl_vars['doc']->value->{'9129_WorkIdentifier_ss'};?>
</a>
        <?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'9119_ManifestationIdentifier_ss'})) {?>
          manifestations:
          <a href="#" class="record-link" data="9119_ManifestationIdentifier_ss"><?php echo $_smarty_tpl->tpl_vars['doc']->value->{'9119_ManifestationIdentifier_ss'};?>
</a>
        <?php }?>
      </div>
    <?php }?>

    <div class="details" id="details-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
      <ul class="nav nav-tabs" id="record-views-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-raw-tab-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" href="#marc-raw-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"
             aria-controls="marc-raw-tab">MARC21</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-leader-tab-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" href="#marc-leader-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"
             aria-controls="marc-leader-tab">Leader explained</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-008-tab-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" href="#marc-008-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"
             aria-controls="marc-008-tab">008 explained</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-human-tab-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" href="#marc-human-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"
             aria-controls="marc-human-tab">labels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-issue-tab-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" href="#marc-issue-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"
             aria-controls="marc-issue-tab" data-id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">issues</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="marc-raw-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" role="tabpanel"
             aria-labelledby="data-tab">
          <div class="marc-details" id="marc-details-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
            <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->record_sni)) {?>
              <table>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, getMarcFields($_smarty_tpl->tpl_vars['doc']->value), 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                  <tr>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'cell');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cell']->value) {
?>
                      <td><?php echo $_smarty_tpl->tpl_vars['cell']->value;?>
</td>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                  </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </table>
            <?php }?>
          </div>
        </div>
        <div class="tab-pane marc-leader" id="marc-leader-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" role="tabpanel"
             aria-labelledby="data-tab">
          <?php $_smarty_tpl->_subTemplateRender('file:marc/leader.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
        </div>
        <div class="tab-pane marc-008" id="marc-008-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" role="tabpanel"
             aria-labelledby="data-tab">
          <?php $_smarty_tpl->_subTemplateRender('file:marc/008.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
        </div>
        <div class="tab-pane" id="marc-human-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" role="tabpanel"
             aria-labelledby="data-tab">
          <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, getAllSolrFields($_smarty_tpl->tpl_vars['doc']->value), 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
              <li>
                <span class="label"><?php echo $_smarty_tpl->tpl_vars['field']->value->label;?>
:</span>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value->value, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_8_saved = $_smarty_tpl->tpl_vars['value'];
?>
                  <?php echo $_smarty_tpl->tpl_vars['value']->value;
if (!$_smarty_tpl->tpl_vars['value']->last) {?> &mdash; <?php }?>
                <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_8_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          </ul>
        </div>
        <div class="tab-pane" id="marc-issue-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" role="tabpanel"
             aria-labelledby="data-tab">
          <p>Retrieving issues detected in this MARC record (if any). It might take for a while.</p>
        </div>
      </div>
    </div>
  </div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
