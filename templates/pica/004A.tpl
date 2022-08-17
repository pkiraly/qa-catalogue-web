{assign var="fieldInstances" value=$record->getFields('004A')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">ISBN:</td>
  <td>
    {foreach from=$fieldInstances item=$field name="fields"}
      {if isset($field->subfields->{'0'})}<span class="004A$a">{$field->subfields->{'0'}}</span>{/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
