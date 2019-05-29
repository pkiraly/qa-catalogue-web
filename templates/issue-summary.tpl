<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames as $field}
        <th>{if field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
    {foreach $types item=type name=types}
      <tr class="type-header {$type}">
        <td colspan="3" class="type"><span class="type">{$type}</span> ({$typeCounter[$type]->variations} variants)
          <a href="javascript:openType('{$smarty.foreach.types.index}')">[+]</a></td>
        <td class="count">{$typeCounter[$type]->count}</td>
      </tr>
      {foreach $records[$type] item=rowData name=foo}
        {if $smarty.foreach.foo.index < 100}
          <tr class="t t-{$smarty.foreach.types.index}">
            {foreach from=$rowData key=field item=content}
              <td class="{$field}">
                {if $field == 'path'}
                  {$content}
                {elseif $field == 'message'}
                  {if preg_match('/^ +$/', $content)}"{$content}"{else}{$content}{/if}
                {elseif $field == 'url'}
                  <a href="{showMarcUrl($content)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
                {elseif $field == 'count'}
                  <a href="#" data-type="{$type}" data-path="{$rowData->path}" data-message="{$rowData->message}">{$content}</a>
                {/if}
              </td>
            {/foreach}
          </tr>
        {/if}
      {/foreach}
      {if $typeCounter[$type]->variations > 100}
        <tr class="t t-{$smarty.foreach.types.index} text-centered {$type}">
          <td colspan="4">more</td>
        </tr>
      {/if}
    {/foreach}
  </tbody>
</table>

