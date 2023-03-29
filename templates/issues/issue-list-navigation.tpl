{*
   $categoryId
   $typeId
   $pages
   $recordCount
   $path
*}
<tr class="t t-{$categoryId}-{$typeId} text-centered">
  <td colspan="8">
    {_('count')}: {$recordCount} |
    {if $listType == 'filtered-list'}
      {_('filter')}: <em>{$path}</em> |
    {/if}
    {if $recordCount > 100}
      {foreach from=$pages item=page}
        <a class="clickMore clickMore-{$categoryId}-{$typeId}"
           {if $page == 0}style="font-weight: bold"{/if}
           id="clickMore-{$categoryId}-{$typeId}-{$page}"
           data-id="{$categoryId}-{$typeId}"
           data-page="{$categoryId}-{$typeId}-{$page}"
           href="{$controller->sortIssuesLink($categoryId, $typeId, $path, $order, $page)}">[{$page+1}]</a>
      {/foreach}
      {if $listType == 'filtered-list'}
        |
        <a class="clickMore clickMore-{$categoryId}-{$typeId}"
           style="font-weight: bold"
           id="clickMore-{$categoryId}-{$typeId}-0"
           data-id="{$categoryId}-{$typeId}"
           data-page="{$categoryId}-{$typeId}-0"
           href="{$controller->sortIssuesLink($categoryId, $typeId, null, $order)}">{_('list all')}</a>
      {/if}
    {else}
      <a class="clickMore clickMore-{$categoryId}-{$typeId}"
         style="font-weight: bold"
         id="clickMore-{$categoryId}-{$typeId}-0"
         data-id="{$categoryId}-{$typeId}"
         data-page="{$categoryId}-{$typeId}-0"
         href="{$controller->sortIssuesLink($categoryId, $typeId, null, $order)}">{_('list all')}</a>
    {/if} |
    <a class="byTag byTag-{$categoryId}-{$typeId}"
       id="byTag-{$categoryId}-{$typeId}"
       data-id="{$categoryId}-{$typeId}"
       href="{$controller->issueByTagLink($categoryId, $typeId)}">{_('grouped by tag')}</a>
  </td>
</tr>
