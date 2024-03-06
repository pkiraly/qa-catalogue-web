{* 6510_Geographic_authorityRecordControlNumber_ss *}
{assign var="fieldInstances" value=$record->getFields('651')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>geographic names</em>:</td>
  <td>
    {foreach from=$fieldInstances item=field}
      <span class="651">
        <i class="fa fa-map" aria-hidden="true" title="geographic term"></i>
        {foreach from=$field->subfields key=code item=value name=subfields}
          {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
          {if $code == 'a'}
            <a href="{$record->filter('651a_Geographic_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'e'}
            relator: <a href="{$record->filter('651e_Geographic_relator_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'g'}
            miscellaneous: <a href="{$record->filter('651g_Geographic_miscellaneous_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '4'}
            relationship: <a href="{$record->filter('6514_Geographic_relationship_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'v'}
            form: <a href="{$record->filter('651v_Geographic_formSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'x'}
            general: <a href="{$record->filter('651x_Geographic_generalSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'y'}
            chronological: <a href="{$record->filter('651y_Geographic_chronologicalSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == 'z'}
            geographic: <a href="{$record->filter('651z_Geographic_geographicSubdivision_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '0'}
            authority ID: <a href="{$record->filter('6510_Geographic_authorityRecordControlNumber_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}}</a>{$comma}
          {elseif $code == '1'}
            url: <a href="{$record->filter('6501', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {elseif $code == '2'}
            vocabulary: <a href="{$record->filter('6512_Geographic_source_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
          {/if}
        {/foreach}
      </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
