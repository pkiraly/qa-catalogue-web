{if count($issues) == 0}
<p>The tool has not detected any issues in this record</p>
{else}
<table id="issues-table">
  <thead>
    <tr>
      {foreach from=$fieldNames item=field}
        <th class="{$field}">{if $field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
    {foreach from=$types item=type name=types}
      <tr class="type-header {$type}">
        <td colspan="3" class="type"><span class="type">{$type}</span> ({count($issues[$type])} variant(s))
        <td class="count">{$typeCounter[$type]}</td>
      </tr>
      {foreach from=$issues[$type] item=rowData name=foo}
        <tr class="t-{$smarty.foreach.types.index}">
          <td class="path">{$rowData->path}</td>
          <td class="message">
            {include "../message.tpl" message=$rowData->message}
          </td>
          <td class="url">
            {if !empty($rowData->url)}
              <a href="{showMarcUrl($rowData->url)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
            {/if}
          </td>
          <td class="count">{$rowData->count}</td>
        </tr>
      {/foreach}
    {/foreach}
  </tbody>
</table>
{/if}
