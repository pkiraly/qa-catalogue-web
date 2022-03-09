{if count($records) > 1}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId}">
    <td class="path">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=MarcPath ASC">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      data element
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=MarcPath DESC">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="message">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=message ASC">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      message
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=message DESC">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="url"></td>
    <td class="count instances">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=instances ASC">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=instances DESC">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count records">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=records ASC">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null($path)}&path={$path}{/if}&order=records DESC">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="actions">
      <a href="{$rowData->queryUrl}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
      <a href="{$rowData->downloadUrl}" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
    </td>
    <td class="chart"></td>
    <td class="percent text-right"></td>
  </tr>
{/if}
{foreach $records item="rowData" name="foo"}
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
{/foreach}
{include file="issue-list-navigation.tpl"}
