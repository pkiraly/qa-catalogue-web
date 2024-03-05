{* EDITION STATEMENT *}
{assign var="fieldInstances" value=$record->getFields('205')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('edition')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="205">
          {foreach from=$field->subfields key=code item=value name=subfields}
            {if $code == 'f'}/{/if}
            {if $code == 'b'}:{/if}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
