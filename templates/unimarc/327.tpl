{* CONTENTS NOTE *}
{assign var="fieldInstances" value=$record->getFields('327')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('contents note')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="327">
          {foreach from=$field->subfields key=code item=value name=subfields}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
