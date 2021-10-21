{if count($records) > 1}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId}">
    <td class="path" colspan="2">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=path ASC">
        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      data element
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=path DESC">
        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="message">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=variants ASC">
      <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      variants
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=variants DESC">
      <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count instances">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=instances ASC">
      <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=instances DESC">
      <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="count records">
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=records ASC">
      <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></a>
      <a class="byTag byTag-{$categoryId}-{$typeId}" data-id="{$categoryId}-{$typeId}"
         href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}&order=records DESC">
      <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></a>
    </td>
    <td class="actions"></td>
    <td class="chart"></td>
    <td class="percent text-right"></td>
  </tr>
{/if}
{foreach $records item="rowData" name="foo"}
  <tr class="t t-{$categoryId}-{$typeId} x-{$categoryId}-{$typeId} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
    <td class="path" colspan="2">{$rowData->path}</td>
    <td class="message">
      <a href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}&path={$rowData->path}" class="byPath" data-id="{$categoryId}-{$typeId}">
        {$rowData->variants|number_format} variants
      </a>
    </td>
    <td class="count instances">{$rowData->instances|number_format}</td>
    <td class="count records">{$rowData->records|number_format}</td>
    <td class="actions"></td>
    <td class="chart"><div style="width: {ceil($rowData->ratio * 200)}px;">&nbsp;</div></td>
    <td class="percent text-right" title="{$rowData->percent|number_format:8}%">{$rowData->percent|number_format:2}</td>
  </tr>
{/foreach}
