{assign var="fieldInstances" value=$record->getFields('013D')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Art und Inhalt:</td>
  <td>
    {foreach from=$fieldInstances item=$field name="fields"}
      {if isset($field->subfields->a)}<span class="013D$a">{$field->subfields->a}</span>{/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
