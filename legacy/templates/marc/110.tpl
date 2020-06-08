{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=getFields($record, '110')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>main corporate names</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="110">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <a href="#" class="record-link" data="110a_MainCorporateName_ss">{$field->subfields->a}</a>
      {* 110b_MainCorporateName_subordinateUnit_ss *}
      {if isset($field->subfields->b)}
        <span class="numeration">{$field->subfields->b}</span>
      {/if}
      {* 110e_MainCorporateName_relatorTerm_ss *}
      {if isset($field->subfields->e)}
        <span class="titles">{$field->subfields->e}</span>
      {/if}
      {* 110g_MainCorporateName_miscellaneous_ss *}
      {if isset($field->subfields->g)}
        <span class="dates">{$field->subfields->g}</span>
      {/if}
      {* 110n_MainCorporateName_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="dates">{$field->subfields->n}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
