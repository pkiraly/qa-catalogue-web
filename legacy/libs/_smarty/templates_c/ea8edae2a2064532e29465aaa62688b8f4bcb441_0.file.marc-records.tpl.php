<?php
/* Smarty version 3.1.33, created on 2019-11-01 10:13:24
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc-records.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dbbf73475cf06_40660997',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea8edae2a2064532e29465aaa62688b8f4bcb441' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc-records.tpl',
      1 => 1572599370,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:conditional-foreach.tpl' => 15,
  ),
),false)) {
function content_5dbbf73475cf06_40660997 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/szte/libs/smarty-3.1.33/libs/plugins/modifier.regex_replace.php','function'=>'smarty_modifier_regex_replace',),));
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['docs']->value, 'doc');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['doc']->value) {
?>
  <?php $_smarty_tpl->_assignInScope('id', smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['doc']->value->id,"/ +"."$"."/",''));?>
  <div class="record">
    <h2>
      <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'245a_Title_mainTitle_ss'})) {?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'245a_Title_mainTitle_ss'), 0, true);
?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'245b_Title_subtitle_ss'), 0, true);
?>
      <?php } elseif (isset($_smarty_tpl->tpl_vars['doc']->value->{'773t_PartOf_title_ss'})) {?>
        <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'773t_PartOf_title_ss'), 0, true);
?>
        <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'245n_Title_partNumber_ss'})) {?>
          <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'245n_Title_partNumber_ss'), 0, true);
?>
        <?php }?>
      <?php }?>
      <a href="#" class="record-details" data="details-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" title="display details"><i class="fa fa-book" aria-hidden="true"></i></a>
      <a href="<?php echo opacLink($_smarty_tpl->tpl_vars['doc']->value,$_smarty_tpl->tpl_vars['doc']->value->id);?>
" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>
    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'245c_Title_responsibilityStatement_ss'})) {?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'245c_Title_responsibilityStatement_ss','label'=>'<i class="fa fa-pencil" aria-hidden="true"></i>','suffix'=>'<br/>'), 0, true);
?>
    <?php } elseif (isset($_smarty_tpl->tpl_vars['doc']->value->{'773a_PartOf_ss'})) {?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'773a_PartOf_ss','label'=>'<i class="fa fa-pencil" aria-hidden="true"></i>','suffix'=>'<br/>'), 0, true);
?>
    <?php }?>
    <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'250a_Edition_editionStatement_ss'), 0, true);
?>

    <?php if (hasPublication($_smarty_tpl->tpl_vars['doc']->value)) {?>
      <i class="fa fa-calendar" aria-hidden="true"></i>
      Published
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'260c_Publication_date_ss','label'=>'in','tag'=>'260c'), 0, true);
?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'260a_Publication_place_ss','label'=>'in','tag'=>'260a'), 0, true);
?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'260b_Publication_agent_ss','label'=>'by','tag'=>'260b'), 0, true);
?>
      <br/>
    <?php }?>

    <?php if (hasPhysicalDescription($_smarty_tpl->tpl_vars['doc']->value)) {?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'300a_PhysicalDescription_extent_ss','tag'=>'300a'), 0, true);
?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'300c_PhysicalDescription_dimensions_ss','tag'=>'300c'), 0, true);
?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'490a_SeriesStatement_ss'})) {?>
      Series:
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'490a_SeriesStatement_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_1_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link tag-490a" data="490a_SeriesStatement_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'490v_SeriesStatement_volume_ss','tag'=>'490v'), 0, true);
?>
      <br/>
    <?php }?>

    <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'520a_Summary_ss','suffix'=>'<br/>'), 0, true);
?>
    <?php $_smarty_tpl->_subTemplateRender('file:conditional-foreach.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('obj'=>$_smarty_tpl->tpl_vars['doc']->value,'key'=>'505a_TableOfContents_ss','suffix'=>'<br/>'), 0, true);
?>

    <?php if (hasMainPersonalName($_smarty_tpl->tpl_vars['doc']->value)) {?>
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'100a_MainPersonalName_personalName_ss'})) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'100a_MainPersonalName_personalName_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_2_saved = $_smarty_tpl->tpl_vars['value'];
?>
          <a href="#" class="record-link" data="100a_MainPersonalName_personalName_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a>
          <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'100d_MainPersonalName_dates_ss'})) {?>
            <?php echo $_smarty_tpl->tpl_vars['doc']->value->{'100d_MainPersonalName_dates_ss'[$_smarty_tpl->tpl_vars['value']->index]};?>

          <?php }?>
          <?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <?php }?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'700a_AddedPersonalName_personalName_ss'})) {?>
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'700a_AddedPersonalName_personalName_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_3_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="700a_AddedPersonalName_personalName_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a>
        <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'700d_AddedPersonalName_dates_ss'})) {?>
          <?php echo $_smarty_tpl->tpl_vars['doc']->value->{'700d_AddedPersonalName_dates_ss'[$_smarty_tpl->tpl_vars['value']->index]};?>

        <?php }?>
        <?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_3_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'710a_AddedCorporateName_ss'})) {?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'710a_AddedCorporateName_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_4_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <?php echo $_smarty_tpl->tpl_vars['value']->value;?>

        <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'710d_AddedCorporateName_dates'})) {?>
          <?php echo $_smarty_tpl->tpl_vars['doc']->value->{'710d_AddedCorporateName_dates'[$_smarty_tpl->tpl_vars['value']->index]};?>

        <?php }?>
        <?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_4_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'650a_Topic_topicalTerm_ss'})) {?>
      <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'650a_Topic_topicalTerm_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_5_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="650a_Topic_topicalTerm_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_5_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'650z_Topic_geographicSubdivision_ss'})) {?>
      <i class="fa fa-map" aria-hidden="true" title="geographic subdivision"></i>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'650z_Topic_geographicSubdivision_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_6_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="650z_Topic_geographicSubdivision_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_6_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'650v_Topic_formSubdivision_ss'})) {?>
      <i class="fa fa-tag" aria-hidden="true" title="form"></i>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'650v_Topic_formSubdivision_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_7_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_7_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'6500_Topic_authorityRecordControlNumber_ss'})) {?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'6500_Topic_authorityRecordControlNumber_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_8_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="6500_Topic_authorityRecordControlNumber_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_8_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'6510_Geographic_authorityRecordControlNumber_ss'})) {?>
      <i class="fa fa-map" aria-hidden="true"></i>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'6510_Geographic_authorityRecordControlNumber_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_9_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="6510_Geographic_authorityRecordControlNumber_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_9_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['doc']->value->{'6550_GenreForm_authorityRecordControlNumber_ss'})) {?>
      <i class="fa fa-map" aria-hidden="true"></i>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['doc']->value->{'6550_GenreForm_authorityRecordControlNumber_ss'}, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_10_saved = $_smarty_tpl->tpl_vars['value'];
?>
        <a href="#" class="record-link" data="6550_GenreForm_authorityRecordControlNumber_ss"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a><?php if (!$_smarty_tpl->tpl_vars['value']->last) {?>, <?php }?>
      <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_10_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <br/>
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
             id="marc-raw-tab-<?php echo $_smarty_tpl->tpl_vars['clearId']->value;?>
" href="#marc-raw-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"
             aria-controls="marc-raw-tab">MARC21</a>
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
">isues</a>
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
        <div class="tab-pane" id="marc-human-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" role="tabpanel"
             aria-labelledby="data-tab">
          <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, getFields($_smarty_tpl->tpl_vars['doc']->value), 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
              <li>
                <span class="label"><?php echo $_smarty_tpl->tpl_vars['field']->value->label;?>
:</span>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value->value, 'value', true);
$_smarty_tpl->tpl_vars['value']->iteration = 0;
$_smarty_tpl->tpl_vars['value']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->iteration++;
$_smarty_tpl->tpl_vars['value']->index++;
$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration === $_smarty_tpl->tpl_vars['value']->total;
$__foreach_value_14_saved = $_smarty_tpl->tpl_vars['value'];
?>
                  <?php echo $_smarty_tpl->tpl_vars['value']->value;
if (!$_smarty_tpl->tpl_vars['value']->last) {?> &mdash; <?php }?>
                <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_14_saved;
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
