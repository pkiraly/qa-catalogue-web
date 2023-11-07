{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('029F')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Körperschaft:</td>
  <td>
    {foreach from=$fieldInstances item=field name=fields}
      {if isset($field->subfields->A)}
        <span class="029F$A">{include 'data/subfield.tpl' value=$field->subfields->A}</span>
      {/if}
      {if isset($field->subfields->G)}
        <span class="029F$G">({include 'data/subfield.tpl' value=$field->subfields->G})</span>
      {/if}
      {if isset($field->subfields->F)}
        - <span class="029F$F">{include 'data/subfield.tpl' value=$field->subfields->F}</span>
      {/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
