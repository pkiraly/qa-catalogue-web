{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('029F')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Körperschaft:</td>
  <td>
  {foreach $fieldInstances as $field name=fields}
    <span class="029F$A">
      {$field->subfields->A}
    </span>
    {if isset($field->subfields->G)}
      <span class="029F$A">
        ({$field->subfields->G})
      </span>
    {/if}
    {if isset($field->subfields->F)}
      -
      <span class="029F$F">
        {$field->subfields->F}
      </span>
    {/if}
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
  </td>
</tr>
{/if}
