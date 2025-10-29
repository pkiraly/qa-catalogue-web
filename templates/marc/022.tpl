{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('022')}
{if !is_null($fieldInstances)}
  <em>ISSN:</em>
  {foreach from=$fieldInstances item=field}
    <span class="022">
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code=='a'}
          <span class="isbn">{include 'data/subfield.tpl' value=$value}</span>
        {elseif $code == 'y'}
          <em>incorrect ISSN:</em> <span class="incorrect">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == 'z'}
          <em>canceled ISSN:</em> <span class="canceled">{include 'data/subfield.tpl' value=$value}</span>{$comma}
        {elseif $code == '2'}
          <em>source:</em> <span class="source">{$controller->getIssnSource($value)}</span>{$comma}
        {/if}
      {/foreach}
    </span>
    <br />
  {/foreach}
{/if}