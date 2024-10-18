{* LEGAL DEPOSIT NUMBER *}
{assign var="fieldInstances" value=$record->getFields('021')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('legal deposit number')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="021">
          {foreach from=$field->subfields key=code item=value name=subfields}
            {if $code == 'b'}--{/if}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
