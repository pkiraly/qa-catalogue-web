{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('032@')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Ausgabe:</td>
  <td>
  {foreach $fieldInstances as $field name=fields}
    {if isset($field->subfields->a)}
      <span class="032@">
        {$field->subfields->a}
      </span>
    {/if}
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
  </td>
</tr>
{/if}
