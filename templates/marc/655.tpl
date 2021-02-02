{* 6550_GenreForm_authorityRecordControlNumber_ss *}
{assign var="fieldInstances" value=$record->getFields('655')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>genres/forms</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="655">
      <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
      {foreach $field->subfields as $code => $value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('655a_GenreForm_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'b'}
          non-focus term: <a href="{$record->filter('655b_GenreForm_nonfocusTerm_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'c'}
          facet/hierarchy: <a href="{$record->filter('655c_GenreForm_facet_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'v'}
          form: <a href="{$record->filter('655v_GenreForm_formSubdivision_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'x'}
          general: <a href="{$record->filter('650x_Topic_generalSubdivision_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'y'}
          chronological: <a href="{$record->filter('655y_GenreForm_chronologicalSubdivision_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'z'}
          geographic: <a href="{$record->filter('655z_GenreForm_geographicSubdivision_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '2'}
          vocabulary: <a href="{$record->filter('6552_GenreForm_source_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '0'}
          authority ID: <a href="{$record->filter('6550_GenreForm_authorityRecordControlNumber_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
