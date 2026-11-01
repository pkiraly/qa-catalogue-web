{* Production, Publication, Distribution, Manufacture, and Copyright Notice
   https://www.loc.gov/marc/bibliographic/bd260.html *}
{assign var="fieldInstances" value=$record->getFields('260')}
{if !is_null($fieldInstances)}
  {foreach from=$fieldInstances item=field}
    <span class="260">
      {* 260a_Publication_place_ss *}
      {if isset($field->subfields->a)}
        <span class="field-label">in</span>
        <span class="place">{include 'data/subfield.tpl' value=$field->subfields->a}</span>
      {/if}
      {* 260b_Publication_agent_ss *}
      {if isset($field->subfields->b)}
        <span class="field-label">:</span>
        <span class="name">{include 'data/subfield.tpl' value=$field->subfields->b}</span>
      {/if}
      {* 260c_Publication_date_ss *}
      {if isset($field->subfields->c)}
        <span class="field-label">in</span>
        <span class="date">{include 'data/subfield.tpl' value=$field->subfields->c}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
