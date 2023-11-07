{* Added Entry - Corporate Name, https://www.loc.gov/marc/bibliographic/bd710.html *}
{assign var="fieldInstances" value=$record->getFields('710')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>additional corporate names</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="710">
      <a href="{$record->filter('710a_AddedCorporateName_ss', $field->subfields->a)}" class="record-link" title="Corporate name or jurisdiction name as entry element">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
      {* 710b_AddedCorporateName_subordinateUnit_ss *}
      {if isset($field->subfields->b)}
        <span class="unit" title="Subordinate unit">{include 'data/subfield.tpl' value=$field->subfields->b}</span>
      {/if}
      {*  *}
      {if isset($field->subfields->c)}
        <span class="location" title="Location of meeting">{include 'data/subfield.tpl' value=$field->subfields->c}</span>
      {/if}
      {*  *}
      {if isset($field->subfields->d)}
        <span class="dates" title="Date of meeting or treaty signing">{include 'data/subfield.tpl' value=$field->subfields->d}</span>
      {/if}
      {* 710e_AddedCorporateName_relatorTerm_ss *}
      {if isset($field->subfields->e)}
        <span class="relator" title="Relator term">{include 'data/subfield.tpl' value=$field->subfields->e}</span>
      {/if}
      {* 710f_AddedCorporateName_dateOfAWork_ss *}
      {if isset($field->subfields->f)}
        <span class="date-of-a-work" title="Date of a work">{include 'data/subfield.tpl' value=$field->subfields->f}</span>
      {/if}
      {* 710g_AddedCorporateName_miscellaneous_ss *}
      {if isset($field->subfields->g)}
        <span class="misc" title="Miscellaneous information">{include 'data/subfield.tpl' value=$field->subfields->g}</span>
      {/if}
      {* 710n_AddedCorporateName_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="relator" title="Number of part/section/meeting">{include 'data/subfield.tpl' value=$field->subfields->n}</span>
      {/if}
      {* 710p_AddedCorporateName_nameOfPart_ss *}
      {if isset($field->subfields->p)}
        <span class="relator" title="Name of part/section of a work">{include 'data/subfield.tpl' value=$field->subfields->p}</span>
      {/if}
      {* 710t_AddedCorporateName_titleOfAWork_ss *}
      {if isset($field->subfields->t)}
        <span class="relator" title="Title of a work">{include 'data/subfield.tpl' value=$field->subfields->t}</span>
      {/if}
      {* 7100_AddedCorporateName_authorityRecordControlNumber_ss *}
      {if property_exists($field->subfields, '0')}
        <span class="relator" title="Authority record control number or standard number">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
