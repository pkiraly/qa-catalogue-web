{if count($records) > 1}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId}">
    <td class="path" colspan="2">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'path ASC')}">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      {_('data element')}
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'path DESC')}">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="message">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'variants ASC')}">
      <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      {_('variants')}
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'variants DESC')}">
      <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count instances">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'instances ASC')}">
      <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'instances DESC')}">
      <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count records">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'records ASC')}">
      <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="{$controller->issueByTagLink($categoryId, $typeId, 'records DESC')}">
      <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="actions"></td>
    <td class="chart"></td>
    <td class="percent text-right"></td>
  </tr>
{/if}
{foreach from=$records item="rowData" name="foo"}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
    <td class="path" colspan="2">{if isset($rowData->withPica3)}{$rowData->withPica3}{else}{$rowData->path}{/if}</td>
    <td class="message">
      <a href="{$controller->sortIssuesLink($categoryId, $typeId, $rowData->path)}" class="byPath" data-id="{$categoryId}-{$typeId}">
        {_t('%s variants', $rowData->variants|number_format)}
      </a>
    </td>
    <td class="count instances">{$rowData->instances|number_format}</td>
    <td class="count records">{$rowData->records|number_format}</td>
    <td class="actions"></td>
    <td class="chart"><div style="width: {ceil($rowData->ratio * 200)}px;">&nbsp;</div></td>
    <td class="percent text-right" title="{$rowData->percent|number_format:8}%">{$rowData->percent|number_format:2}</td>
  </tr>
{/foreach}
{include file="issues/issue-list-navigation.tpl"}
