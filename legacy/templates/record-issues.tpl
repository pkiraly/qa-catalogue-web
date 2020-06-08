{if count($issues) == 0}
<p>The tool has not detected any issues in this record</p>
{else}
<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames as $field}
        <th class="{$field}">{if $field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
    {foreach $types item=type name=types}
      <tr class="type-header {$type}">
        <td colspan="3" class="type"><span class="type">{$type}</span> ({count($issues[$type])} variant(s))
        <td class="count">{$typeCounter[$type]}</td>
      </tr>
      {foreach $issues[$type] item=rowData name=foo}
        <tr class="t-{$smarty.foreach.types.index}">
          <td class="path">{$rowData->path}</td>
          <td class="message">
            {if preg_match('/^ +$/', $rowData->message)}"{$rowData->message}"{else}{$rowData->message}{/if}
          </td>
          <td class="url">
            <a href="{showMarcUrl($rowData->url)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
          </td>
          <td class="count">{$rowData->count}</td>
        </tr>
      {/foreach}
    {/foreach}
  </tbody>
</table>
{/if}
