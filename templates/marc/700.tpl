{assign var="fieldInstances" value=getFields($record, '700')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>additional personal names</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="700">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <a href="#" class="record-link" data="700a_AddedPersonalName_personalName_ss">{$field->subfields->a}</a>
      {if isset($field->subfields->b)}
        <span class="numeration">{$field->subfields->b}</span>
      {/if}
      {if isset($field->subfields->c)}
        <span class="titles">{$field->subfields->c}</span>
      {/if}
      {* 700d_AddedPersonalName_dates_ss *}
      {if isset($field->subfields->d)}
        <span class="dates">{$field->subfields->d}</span>
      {/if}
      {if isset($field->subfields->e)}
        <span class="relator">{$field->subfields->e}</span>
      {/if}
      {if isset($field->subfields->{'0'})}
        (authority: <a href="#" class="record-link" data="7000">{$field->subfields->{'0'}}</a>)
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
