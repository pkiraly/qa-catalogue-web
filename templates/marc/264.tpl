{* Production, Publication, Distribution, Manufacture, and Copyright Notice
   https://www.loc.gov/marc/bibliographic/bd264.html *}
{assign var="fieldInstances" value=$record->getFields('264')}
{if !is_null($fieldInstances)}
  {foreach $fieldInstances as $field}
    <span class="264">
      {* 264a_ProvisionActivity_place_ss *}
      {if isset($field->subfields->a)}
        <span class="place">{$field->subfields->a}</span>
      {/if}
      {* 264b_ProvisionActivity_agent_ss *}
      {if isset($field->subfields->b)}
        <span class="name">{$field->subfields->b}</span>
      {/if}
      {* 264c_ProvisionActivity_date_ss *}
      {if isset($field->subfields->c)}
        <span class="date">{$field->subfields->c}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
