{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('040')}
{if !is_null($fieldInstances)}
  <em>Cataloging Source:</em>
  {foreach from=$fieldInstances item=field}
    <span class="040">
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code=='a'}
          <em>original cataloging agency:</em> <a href="{$record->filter('040a_AdminMetadata_catalogingAgency_ss', $value)}" class="cataloging">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          <em>language of cataloging:</em> <span class="language">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'c'}
          <em>transcribing agency:</em> <span class="transcribing">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'd'}
          <em>modifying agency:</em> <span class="modifying">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'e'}
          <em>description conventions:</em> <span class="conventions">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
{/if}
