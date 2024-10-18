{* PROVENANCE NOTE *}
{assign var="fieldInstances" value=$record->getFields('317')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('provenance note')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="317">
          {foreach from=$field->subfields key=code item=value name=subfields}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
