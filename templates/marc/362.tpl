{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('362')}
{if !is_null($fieldInstances)}
  <em>Dates of Publication</em><br>
  {foreach from=$fieldInstances item=field}
    <span class="362">
      {if isset($field->subfields->a)}
        <span class="dates">{include 'data/subfield.tpl' value=$field->subfields->a}</span>
      {/if}
      {if isset($field->subfields->z)}
        <span class="source">{include 'data/subfield.tpl' value=$field->subfields->z}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
