{* SUMMARY/ABSTRACT NOTE *}
{assign var="fieldInstances" value=$record->getFields('330')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('summary/abstract note')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="330">
          {foreach from=$field->subfields key=code item=value name=subfields}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
