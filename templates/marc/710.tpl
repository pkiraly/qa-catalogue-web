{* 710a_AddedCorporateName_ss *}
{assign var="fieldInstances" value=getFields($record, '710')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>additional corporate names</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="710">
      <a href="#" class="record-link" data="710a_AddedCorporateName_ss">{$field->subfields->a}</a>
      {* 710d_AddedCorporateName_dates *}
      {if isset($field->subfields->d)}
        <span class="dates">{$field->subfields->d}</span>
      {/if}
      {if isset($field->subfields->e)}
        <span class="relator">{$field->subfields->e}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
