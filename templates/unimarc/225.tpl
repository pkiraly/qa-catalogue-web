{* SERIES *}
{assign var="fieldInstances" value=$record->getFields('225')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('series')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="225">
          {foreach from=$field->subfields key=code item=value name=subfields}
            {if $code == 'c'}:{/if}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
