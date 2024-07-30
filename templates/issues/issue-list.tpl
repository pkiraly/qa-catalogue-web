{if count($records) > 1}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId}">
    <td class="path">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'MarcPath ASC')}">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      {_t('data element')}
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'MarcPath DESC')}">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="message">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'message ASC')}">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      {_t('message')}
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'message DESC')}">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count instances">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'instances ASC')}">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'instances DESC')}">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count records">
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'records ASC')}">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="clickMore clickMore-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}" data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, $path, 'records DESC')}">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="actions"></td>
    <td class="chart"></td>
    <td class="percent text-right"></td>
  </tr>
{/if}
{foreach from=$records item="rowData" name="foo"}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
    <td class="path">
      {if empty($rowData->url)}
        {if isset($rowData->withPica3)}{$rowData->withPica3}{else}{$rowData->path}{/if}
      {else}
        <a href="{showMarcUrl($rowData->url)}" target="_blank">
          {if isset($rowData->withPica3)}{$rowData->withPica3}{else}{$rowData->path}{/if}
        </a>
      {/if}
    </td>
    <td class="message">
      {include "../message.tpl" message=$rowData->message}
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
{include file="issues/issue-list-navigation.tpl"}
