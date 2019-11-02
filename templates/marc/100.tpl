{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=getFields($record, '100')}
{if !is_null($fieldInstances)}
  <em>Main personal names</em><br>
  {foreach $fieldInstances as $field}
    <span class="100">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <a href="#" class="record-link" data="100a_MainPersonalName_personalName_ss">{$field->subfields->a}</a>
      {if isset($field->subfields->b)}
        <span class="numeration">{$field->subfields->b}</span>
      {/if}
      {if isset($field->subfields->c)}
        <span class="titles">{$field->subfields->c}</span>
      {/if}
      {* 100d_MainPersonalName_dates_ss *}
      {if isset($field->subfields->d)}
        <span class="dates">{$field->subfields->d}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
