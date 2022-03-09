{*
   $categoryId
   $typeId
   $pages
   $recordCount
   $path
*}
<tr class="t t-{$categoryId}-{$typeId} text-centered">
  <td colspan="8">
    count: {$recordCount} |
    {if $listType == 'filtered-list'}
      filter: <em>{$path}</em> |
    {/if}
    {if $recordCount > 100}
      {foreach from=$pages item=page}
        <a class="clickMore clickMore-{$categoryId}-{$typeId}"
           {if $page == 0}style="font-weight: bold"{/if}
           id="clickMore-{$categoryId}-{$typeId}-{$page}"
           data-id="{$categoryId}-{$typeId}"
           data-page="{$categoryId}-{$typeId}-{$page}"
           href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if !is_null({$path})}{if isset($order)}&order={$order}{/if}&path={$path}{/if}&page={$page}">[{$page+1}]</a>
      {/foreach}
      {if $listType == 'filtered-list'}
        |
        <a class="clickMore clickMore-{$categoryId}-{$typeId}"
           style="font-weight: bold"
           id="clickMore-{$categoryId}-{$typeId}-0"
           data-id="{$categoryId}-{$typeId}"
           data-page="{$categoryId}-{$typeId}-0"
           href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if isset($order)}&order={$order}{/if}">list all</a>
      {/if}
    {else}
      <a class="clickMore clickMore-{$categoryId}-{$typeId}"
         style="font-weight: bold"
         id="clickMore-{$categoryId}-{$typeId}-0"
         data-id="{$categoryId}-{$typeId}"
         data-page="{$categoryId}-{$typeId}-0"
         href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$categoryId}&typeId={$typeId}{if isset($order)}&order={$order}{/if}">list all</a>
    {/if} |
    <a class="byTag byTag-{$categoryId}-{$typeId}"
       id="byTag-{$categoryId}-{$typeId}"
       data-id="{$categoryId}-{$typeId}"
       href="?tab=issues&ajax=1&action=ajaxIssueByTag&categoryId={$categoryId}&typeId={$typeId}">grouped by tag</a>
  </td>
</tr>
