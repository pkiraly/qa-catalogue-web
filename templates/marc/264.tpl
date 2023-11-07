{* Production, Publication, Distribution, Manufacture, and Copyright Notice
   https://www.loc.gov/marc/bibliographic/bd264.html *}
{assign var="fieldInstances" value=$record->getFields('264')}
{if !is_null($fieldInstances)}
  {foreach from=$fieldInstances item=field}
    <span class="264">
      {* 264a_ProvisionActivity_place_ss *}
      {if isset($field->subfields->a)}
        <span class="place">{include 'data/subfield.tpl' value=$field->subfields->a}</span>
      {/if}
      {* 264b_ProvisionActivity_agent_ss *}
      {if isset($field->subfields->b)}
        <span class="name">{include 'data/subfield.tpl' value=$field->subfields->b}</span>
      {/if}
      {* 264c_ProvisionActivity_date_ss *}
      {if isset($field->subfields->c)}
        <span class="date">{include 'data/subfield.tpl' value=$field->subfields->c}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
