{foreach $records item="rowData" name="foo"}
  {if $smarty.foreach.foo.index < 100}
    <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
      <td class="path">{$rowData->path}</td>
      <td class="message">
        {if preg_match('/^ +$/', $rowData->message)}"{$rowData->message}"{else}{$rowData->message}{/if}
      </td>
      <td class="url">
        <a href="{showMarcUrl($rowData->url)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
      </td>
      <td class="count instances">{$rowData->instances|number_format}</td>
      <td class="count records">{$rowData->records|number_format}</td>
      <td class="actions">
        <a href="{$rowData->queryUrl}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
        <a href="{$rowData->downloadUrl}" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
      </td>
      <td class="chart"><div style="width: {ceil($rowData->ratio * 200)}px;">&nbsp;</div></td>
      <td class="percent text-right" title="{$rowData->percent|number_format:8}%">{$rowData->percent|number_format:2}</td>
    </tr>
  {/if}
{/foreach}
