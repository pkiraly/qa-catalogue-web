{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('021A')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Titel:</td>
  <td>
    {foreach from=$fieldInstances item=field name=fields}
      {if isset($field->subfields->a)}<span class="021A$a">{$field->subfields->a}</span>{/if}
      {if isset($field->subfields->d)} : <span class="021A$d">{$field->subfields->d}</span>{/if}
      {if isset($field->subfields->h)} / <span class="021A$d">{$field->subfields->h}</span>{/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
