{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('801')}
{if !is_null($fieldInstances)}
  <em>Originating Source:</em>
  {foreach from=$fieldInstances item=field}
    <span class="040">
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code=='a'}
          <em>country:</em> <span class="country">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'b'}
          <em>original cataloging agency:</em> <a href="{$record->filter('801b_ss', $value)}" class="cataloging">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          <em>date:</em> <span class="date">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'g'}
          <em>description conventions:</em> <span class="conventions">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
{/if}
