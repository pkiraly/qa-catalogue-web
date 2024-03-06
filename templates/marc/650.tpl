{assign var="fieldInstances" value=$record->getFields('650')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>topics</em>:</td>
  <td>
    {foreach from=$fieldInstances item=field}
      <span class="650">
        <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
        {foreach from=$field->subfields key=code item=value name=subfields}
          {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
          {if $code == 'a'}
            <a href="{$record->filter('650a_Topic_topicalTerm_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'b'}
            <a href="{$record->filter('650b_Topic_topicalTerm_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'c'}
            event location: <a href="{$record->filter('650c_Topic_locationOfEvent_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'd'}
            dates: <a href="{$record->filter('650d_Topic_activeDates_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'e'}
            relator: <a href="{$record->filter('650e_Topic_relatorTerm_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'g'}
            miscellaneous: <a href="{$record->filter('650g_Topic_miscellaneousInformation_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '4'}
            relationship: <a href="{$record->filter('6504_Topic_relationship_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'v'}
            form: <a href="{$record->filter('650v_Topic_formSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'x'}
            general: <a href="{$record->filter('650x_Topic_generalSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'y'}
            chronological: <a href="{$record->filter('650y_Topic_chronologicalSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'z'}
            geographic: <a href="{$record->filter('650z_Topic_geographicSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '0'}
            authority ID: <a href="{$record->filter('6500_Topic_authorityRecordControlNumber_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '1'}
            url: <a href="{$record->filter('6501', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '2'}
            vocabulary: <a href="{$record->filter('6502_Topic_sourceOfHeading_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {/if}
        {/foreach}
      </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
