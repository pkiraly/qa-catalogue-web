{assign var="fieldInstances" value=$record->getFields('010@')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Sprache(n):</td>
  <td>
    {foreach from=$fieldInstances item=$field name="fields"}
      {if isset($field->subfields->a)}<span class="010@$a">{$field->subfields->a}</span>{/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
