{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('033A')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Erschienen:</td>
  <td>
  {foreach from=$fieldInstances item=$field name="fields"}
    {if isset($field->subfields->p)}<span class="033A$p">{$field->subfields->p}</span>{if !isset($field->subfields->n)},{/if}{/if}
    {if isset($field->subfields->n)}: <span class="033A$n">{$field->subfields->n}</span>,{/if}
    {$record->getField('011@')->subfields->a}
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
  </td>
</tr>
{/if}
