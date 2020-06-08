<?php
/* Smarty version 3.1.33, created on 2019-11-19 12:40:22
  from '/home/kiru/git/metadata-qa-marc-web/templates/marc/leader.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd3d4a6ab14b4_07399810',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52fb5170ef4da10117d26773a229109145661b9e' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/marc/leader.tpl',
      1 => 1574163574,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd3d4a6ab14b4_07399810 (Smarty_Internal_Template $_smarty_tpl) {
?><p>
  Leader: <?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_ss',TRUE);?>
<br/>
  type*: <?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'type_ss');?>
<br>
  Leader contains general information. It is a row of fixed-length data elements, such that
  there is no formal separators between elements, only the standard sets the boundaries
  by its positions (e.g. 00-04 means that the part of the whole string from 0th to 4th character).
  Some parts contain numeric values, such as lenght of the record, some others contain
  encoded information (e.g. in 6th position "a" means <em>Language material</em>).
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
    <td>00-04</td>
    <td>length:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,0,4);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>05</td>
    <td>record status:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,5);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_05_recordStatus_ss');?>
</td>
  </tr>
  <tr>
    <td>06</td>
    <td>type of record:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,6);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_06_typeOfRecord_ss');?>
</td>
  </tr>
  <tr>
    <td>07</td>
    <td>bibliographic level:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,7);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_07_bibliographicLevel_ss');?>
</td>
  </tr>
  <tr>
    <td>08</td>
    <td>type of control:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,8);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_08_typeOfControl_ss');?>
</td>
  </tr>
  <tr>
    <td>09</td>
    <td>character coding scheme:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,9);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_09_characterCodingScheme_ss');?>
</td>
  </tr>
  <tr>
    <td>10</td>
    <td>indicator count:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,10);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>11</td>
    <td>subfield code count:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,11);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>12-16</td>
    <td>base address of data:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,12,16);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>17</td>
    <td>encoding level:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,17);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_17_encodingLevel_ss');?>
</td>
  </tr>
  <tr>
    <td>18</td>
    <td>descriptive cataloging form:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,18);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_18_descriptiveCatalogingForm_ss');?>
</td>
  </tr>
  <tr>
    <td>19</td>
    <td>multipart resource record level:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,19);?>
</td>
    <td><?php echo getFirstField($_smarty_tpl->tpl_vars['doc']->value,'Leader_19_multipartResourceRecordLevel_ss');?>
</td>
  </tr>
  <tr>
    <td>20</td>
    <td>length of field portion:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,20);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>21</td>
    <td>length of the starting character position portion:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,21);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>22</td>
    <td>length of the implementation defined portion:</td>
    <td><?php echo getLeaderByPosition($_smarty_tpl->tpl_vars['doc']->value,22);?>
</td>
    <td></td>
  </tr>
  <tr>
    <td>23</td>
    <td>undefined</td>
    <td>0</td>
    <td></td>
  </tr>
  </tbody>
</table>

<p>* Type comes from the combination of type of record (06) and bibliographic level (07) positions.
  See 'Dependencies' section of
  <a href="https://www.loc.gov/marc/bibliographic/bdleader.html" target="_blank">Leader</a></p><?php }
}
