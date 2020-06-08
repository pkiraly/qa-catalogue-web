<?php
/* Smarty version 3.1.33, created on 2019-11-19 12:40:22
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/008.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd3d4a6b8ff25_45588541',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '724afdd7a568f287e1d7db82cb124d0e8b5b6073' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/008.tpl',
      1 => 1574163614,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd3d4a6b8ff25_45588541 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('type', getFirstField($_smarty_tpl->tpl_vars['doc']->value,'type_ss'));?>
<p>
  008: <?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_GeneralInformation_ss',TRUE);?>
<br/>
  type*: <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
<br/>
  Field 008 contains general information. It is a row of fixed-length data elements, such that
  there is no formal separators between elements, only the standard sets the boundaries
  by its positions (e.g. 00-05 means that the part of the whole string from 0th to 5th character).
  008 separates the string into three blocks: from 0 to 17th position it encodes general
  information, from 18th to 34th comes information specific to the record's type, and from 35th
  till the end of the string the general information continues.
  Some parts contain numeric values, such as length of the record, some others contain
  encoded information (e.g. in 6th position "s" means <em>Single known date/probable date</em>).
</p>
<table>
  <thead>
  <tr>
    <th>pos.</th>
    <th>field</th>
    <th>value</th>
    <th>meaning</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td colspan="4"><strong>General</strong></td>
  </tr>
  <tr>
    <td>00-05</td>
    <td>Date entered on file:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,0,6);?>
</td>
    <td><?php echo formatMarcDate(getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_00-05_GeneralInformation_dateEnteredOnFile_ss'));?>
</td>
  </tr>
  <tr>
    <td>06</td>
    <td>Type of date/Publication status:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,6);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_06_GeneralInformation_typeOfDateOrPublicationStatus_ss');?>
</td>
  </tr>
  <tr>
    <td>07-10</td>
    <td>Date 1:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,7,11);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_07-10_GeneralInformation_date1_ss');?>
</td>
  </tr>
  <tr>
    <td>11-14</td>
    <td>Date 2:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,11,15);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_11-14_GeneralInformation_date2_ss');?>
</td>
  </tr>
  <tr>
    <td>15-17</td>
    <td>Place of publication, production, or execution:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,15,18);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_15-17_GeneralInformation_placeOfPublicationProductionOrExecution_ss');?>
</td>
  </tr>
  <tr>
    <td colspan="4"><strong><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</strong></td>
  </tr>
<?php if ($_smarty_tpl->tpl_vars['type']->value == 'Books') {?>
  <tr>
    <td>18-21</td>
    <td>Illustrations:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,18,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_18-21_GeneralInformation_illustrations_ss');?>
</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_22_GeneralInformation_targetAudience_ss');?>
</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,23);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_23_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
  <tr>
    <td>24-27</td>
    <td>Nature of contents:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,24,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_24-27_GeneralInformation_natureOfContents_ss');?>
</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_28_GeneralInformation_governmentPublication_ss');?>
</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Conference publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,29);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_29_GeneralInformation_conferencePublication_ss');?>
</td>
  </tr>
  <tr>
    <td>30</td>
    <td>Festschrift:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,30);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_30_GeneralInformation_festschrift_ss');?>
</td>
  </tr>
  <tr>
    <td>31</td>
    <td>Index:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,31);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_31_GeneralInformation_index_ss');?>
</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Literary form:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,33);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_33_GeneralInformation_literaryForm_ss');?>
</td>
  </tr>
  <tr>
    <td>34</td>
    <td>Biography:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,34);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_34_GeneralInformation_biography_ss');?>
</td>
  </tr>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Maps') {?>
  <tr>
    <td>18-21</td>
    <td>Relief:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,18,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_18-21_GeneralInformation_relief_ss');?>
</td>
  </tr>
  <tr>
    <td>22-23</td>
    <td>Projection:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,22,24);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_22-23_GeneralInformation_projection_ss');?>
</td>
  </tr>
  <tr>
    <td>25</td>
    <td>Type of cartographic material:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,25);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_25_GeneralInformation_typeOfCartographicMaterial_ss');?>
</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_28_GeneralInformation_governmentPublication_ss');?>
</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,29);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_29_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
  <tr>
    <td>31</td>
    <td>Index:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,31);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_31_GeneralInformation_index_ss');?>
</td>
  </tr>
  <tr>
    <td>33-34</td>
    <td>Special format characteristics:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,33,35);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_33-34_GeneralInformation_specialFormatCharacteristics_ss');?>
</td>
  </tr>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Computer Files') {?>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_22_GeneralInformation_targetAudience_ss');?>
</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,23);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_23_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
  <tr>
    <td>26</td>
    <td>Type of computer file:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,26);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_26_GeneralInformation_typeOfComputerFile_ss');?>
</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_28_GeneralInformation_governmentPublication_ss');?>
</td>
  </tr>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Music') {?>
  <tr>
    <td>18-19</td>
    <td>Form of composition:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,18,20);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_18-19_GeneralInformation_formOfComposition_ss');?>
</td>
  </tr>
  <tr>
    <td>20</td>
    <td>Format of music:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,20);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_20_GeneralInformation_formatOfMusic_ss');?>
</td>
  </tr>
  <tr>
    <td>21</td>
    <td>Music parts:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,21);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_21_GeneralInformation_musicParts_ss');?>
</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_22_GeneralInformation_targetAudience_ss');?>
</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,23);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_23_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
  <tr>
    <td>24-29</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,24,30);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_24-29_GeneralInformation_accompanyingMatter_ss');?>
</td>
  </tr>
  <tr>
    <td>30-31</td>
    <td>Literary text for sound recordings:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,30,32);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_30-31_GeneralInformation_literaryTextForSoundRecordings_ss');?>
</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Transposition and arrangement:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,33);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_33_GeneralInformation_transpositionAndArrangement_ss');?>
</td>
  </tr>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Continuing Resources') {?>
  <tr>
    <td>18</td>
    <td>Frequency:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,18);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_18_GeneralInformation_frequency_ss');?>
</td>
  </tr>
  <tr>
    <td>19</td>
    <td>Regularity:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,19);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_19_GeneralInformation_regularity_ss');?>
</td>
  </tr>
  <tr>
    <td>21</td>
    <td>Type of continuing resource:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,21);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_21_GeneralInformation_typeOfContinuingResource_ss');?>
</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Form of original item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_22_GeneralInformation_formOfOriginalItem_ss');?>
</td>
  </tr>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,23);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_23_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
  <tr>
    <td>24</td>
    <td>Nature of entire work:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,24);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_24_GeneralInformation_natureOfEntireWork_ss');?>
</td>
  </tr>
  <tr>
    <td>25-27</td>
    <td>Nature of contents:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,25,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_25-27_GeneralInformation_natureOfContents_ss');?>
</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_28_GeneralInformation_governmentPublication_ss');?>
</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Conference publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,29);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_29_GeneralInformation_conferencePublication_ss');?>
</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Original alphabet or script of title:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,33);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_33_GeneralInformation_originalAlphabetOrScriptOfTitle_ss');?>
</td>
  </tr>
  <tr>
    <td>34</td>
    <td>Entry convention:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,34);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_34_GeneralInformation_entryConvention_ss');?>
</td>
  </tr>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Visual Materials') {?>
  <tr>
    <td>18-20</td>
    <td>Running time for motion pictures and videorecordings:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,18,21);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_18-20_GeneralInformation_runningTime_ss');?>
</td>
  </tr>
  <tr>
    <td>22</td>
    <td>Target audience:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,22);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_22_GeneralInformation_targetAudience_ss');?>
</td>
  </tr>
  <tr>
    <td>28</td>
    <td>Government publication:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,28);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_28_GeneralInformation_governmentPublication_ss');?>
</td>
  </tr>
  <tr>
    <td>29</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,29);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_29_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
  <tr>
    <td>33</td>
    <td>Type of visual material:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,33);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_33_GeneralInformation_typeOfVisualMaterial_ss');?>
</td>
  </tr>
  <tr>
    <td>34</td>
    <td>Technique:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,34);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_34_GeneralInformation_technique_ss');?>
</td>
  </tr>
<?php } elseif ($_smarty_tpl->tpl_vars['type']->value == 'Mixed Materials') {?>
  <tr>
    <td>23</td>
    <td>Form of item:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,23);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_23_GeneralInformation_formOfItem_ss');?>
</td>
  </tr>
<?php }?>
  <tr>
    <td colspan="4"><strong>General (continued)</strong></td>
  </tr>
  <tr>
    <td>35-37</td>
    <td>Language:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,35,38);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_35-37_GeneralInformation_language_ss');?>
</td>
  </tr>
  <tr>
    <td>38</td>
    <td>Modified record:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,38);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_38_GeneralInformation_modifiedRecord_ss');?>
</td>
  </tr>
  <tr>
    <td>39</td>
    <td>Cataloging source:</td>
    <td><?php echo get008ByPosition($_smarty_tpl->tpl_vars['doc']->value,39);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'008_39_GeneralInformation_catalogingSource_ss');?>
</td>
  </tr>
  </tbody>
</table>

<p>* Type comes from the combination of type of record (06) and bibliographic level (07) positions.
  See 'Dependencies' section of
  <a href="https://www.loc.gov/marc/bibliographic/bdleader.html" target="_blank">Leader</a></p><?php }
}
