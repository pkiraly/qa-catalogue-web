{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('021A')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Titel:</td>
  <td>
  {foreach $fieldInstances as $field name=fields}
    <span class="021A">
      {foreach $field->subfields as $code => $value name=subfields}
        <span class="{$code}">{$value}</span> {if !$smarty.foreach.subfields.last}/{/if}
      {/foreach}
    </span>
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
  </td>
</tr>
{/if}
