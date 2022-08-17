{assign var="fieldInstances" value=$record->getFields('036E')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Schriftenreihe:</td>
  <td>
    {foreach from=$fieldInstances item=field name="fields"}
      {if isset($field->subfields->a)}<span class="036E$a">{$field->subfields->a}</span>{/if}
      {if isset($field->subfields->l)}; <span class="036E$l">{$field->subfields->l}</span>{/if}
      {if isset($field->subfields->p)}. <span class="036E$p">{$field->subfields->p}</span>{/if}
      {if isset($field->subfields->m)}; <span class="036E$m">{$field->subfields->m}</span>{/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
