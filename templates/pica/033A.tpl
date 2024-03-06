{assign var="fieldInstances" value=$record->getFields('033A')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Erschienen:</td>
  <td>
    {foreach from=$fieldInstances item=field name="fields"}
      {if isset($field->subfields->p)}<span class="033A$p">{include 'data/subfield.tpl' value=$field->subfields->p}</span>{if !isset($field->subfields->n)},{/if}{/if}
      {if isset($field->subfields->n)}: <span class="033A$n">{include 'data/subfield.tpl' value=$field->subfields->n}</span>,{/if}
      {include 'data/subfield.tpl' value=$record->getField('011@')->subfields->a}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
