{* Added Entry - Uniform Title, https://www.loc.gov/marc/bibliographic/bd740.html *}
{assign var="fieldInstances" value=$record->getFields('740')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uncontrolled related/analytical title</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="740">
      <i class="fa fa-user" aria-hidden="true" title="Uncontrolled related/analytical title"></i>
      <a href="{$record->filter('740a_ss', $field->subfields->a)}" class="record-link" title="Uncontrolled related/analytical title">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
      {*  *}
      {if isset($field->subfields->h)}
        <span class="medium" title="Medium">{include 'data/subfield.tpl' value=$field->subfields->h}</span>
      {/if}
      {* 740n_AddedUniformTitle_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="part" title="Number of part/section of a work">{include 'data/subfield.tpl' value=$field->subfields->n}</span>
      {/if}
      {* 740p_AddedUniformTitle_nameOfPart_ss *}
      {if isset($field->subfields->p)}
        <span class="part-name" title="Name of part/section of a work">{include 'data/subfield.tpl' value=$field->subfields->p}</span>
      {/if}
      {if property_exists($field->subfields, '5')}
        <span class="institution" title="Institution to which field applies">{include 'data/subfield.tpl' value=$field->subfields->{'5'}}</span>
      {/if}
      {if property_exists($field->subfields, '6')}
        <span class="linkage" title="Linkage">{include 'data/subfield.tpl' value=$field->subfields->{'6'}}</span>
      {/if}
      {if property_exists($field->subfields, '8')}
        <span class="link" title="Field link and sequence number">{include 'data/subfield.tpl' value=$field->subfields->{'8'}}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
