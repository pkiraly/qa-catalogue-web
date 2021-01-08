{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('362')}
{if !is_null($fieldInstances)}
  <em>Dates of Publication</em><br>
  {foreach $fieldInstances as $field}
    <span class="362">
      {if isset($field->subfields->a)}
        <span class="dates">{$field->subfields->a}</span>
      {/if}
      {if isset($field->subfields->z)}
        <span class="source">{$field->subfields->z}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
