{foreach from=$tags key=tagName item=controlField}
  {assign var="record" value=$controlField}
  <tr class="field-level">
    {if $controlField['type'] == 'simpleControlField'}
      <td colspan="2" class="field-level tag" id="completeness-{$record['websafeTag']}">
        {$tagName}
      </td>
      {include 'completeness/completeness-numbers.tpl' record=$controlField['tag']}
    {else}
      <td colspan="11" class="field-level tag" id="completeness-{$record['websafeTag']}">
        <a href="#" class="trigger" data-id="completeness-{$record['websafeTag']}" title="Show subfields">
          <i class="fa fa-folder-closed"></i>
        </a>
        {$tagName}
      </td>
    {/if}
  </tr>
  {if $controlField['type'] == 'leader'}
    {foreach from=$controlField['positions'] item=position}
      {include 'completeness/completeness-control-field.tpl' record=$position}
    {/foreach}
    {* include 'completeness/completeness-numbers.tpl' record=$controlField['tag'] *}
  {elseif $controlField['type'] == 'complexControlField'}
    {foreach from=$controlField['types'] key=typeName item=type}
      <tr class="complex-type complex-type-level completeness-{$controlField['websafeTag']}">
        <td colspan="11" style="text-align: left">{$typeName}</td>
      </tr>
      {foreach from=$type['positions'] item=position}
        {include 'completeness/completeness-control-field.tpl' record=$position}
      {/foreach}
    {/foreach}
  {/if}
{/foreach}