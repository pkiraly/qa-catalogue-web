{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('020')}
{if !is_null($fieldInstances)}
  <em>ISBN:</em>
  {foreach from=$fieldInstances item=field}
    <span class="040">
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code=='a'}
          <span class="isbn">{include 'data/subfield.tpl' value=$value}</span>
        {elseif $code == 'b'}
          <em>binding:</em> <span class="binding">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'c'}
          <em>terms of availability:</em> <span class="availability">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'q'}
          <em>qualifying information:</em> <span class="qualifying">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'z'}
          <em>canceled/invalid ISBN:</em> <span class="canceled">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {/if}
      {/foreach}
    </span>
    <br />
  {/foreach}
{/if}