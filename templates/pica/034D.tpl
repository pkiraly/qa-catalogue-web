{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('034D')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Umfang:</td>
  <td>
    {foreach from=$fieldInstances item=field name="fields"}
      {if isset($field->subfields->a)}<span class="034D$a">{$field->subfields->a}</span>{/if}
      {if isset($record->getField('034M')) && isset($record->getField('034M')->subfields->a)} : {$record->getField('034M')->subfields->a}{/if}
      {if isset($record->getField('034I')) && isset($record->getField('034I')->subfields->a)} ; {$record->getField('034I')->subfields->a}{/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
