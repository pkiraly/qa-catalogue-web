<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">records without issues</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">with</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: {ceil($topStatistics[1]->goodPercent * 5)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$topStatistics[1]->good|number_format:0}
    ({$topStatistics[1]->goodPercent|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics[1]->bad|number_format:0}
    ({$topStatistics[1]->badPercent|number_format:2}%)
  </div>
</div>

<p>excluding undefined field issues</p>
<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">records without issues</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">with</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: {ceil($topStatistics[2]->goodPercent * 5)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$topStatistics[2]->good|number_format:0}
    ({($topStatistics[2]->goodPercent)|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics[2]->bad|number_format:0}
    ({$topStatistics[2]->badPercent|number_format:2}%)
  </div>
</div>

<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames item=field}
        <th {if in_array($field, ['instances', 'records'])}class="text-right"{/if}>{if field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
      <th></th>
      <th>chart</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody>
  {foreach $categories key=index item=category name=categories}
    <tr class="category-header {$category->category}{if !$smarty.foreach.categories.first} padded{/if}">
      <td colspan="3" class="category">
        <span class="category">{$category->category}</span> level issues
      </td>
      <td class="count">{$category->instances|number_format}</td>
      <td class="count">{$category->records|number_format}</td>
      <td class="actions"></td>
      <td class="chart"><div style="width: {ceil($category->ratio * 200)}px;">&nbsp;</div></td>
      <td class="percent text-right" title="{$category->percent|number_format:8}%">{$category->percent|number_format:2}</td>
    </tr>
    {foreach $category->types item=typeId name=types}
      {assign var="type" value=$types[$typeId]}
      <tr class="type-header {$type->type} h-{$category->id}-{$type->id}">
        <td colspan="3" class="type">
          <span class="type">{$type->type}</span> ({$type->variantCount} variants)
          <a href="javascript:openType('{$category->id}-{$type->id}')">[+]</a>
        </td>
        <td class="count">{$type->instances|number_format}</td>
        <td class="count">{$type->records|number_format}</td>
        <td class="actions"></td>
        <td class="chart"><div style="width: {ceil($type->ratio * 200)}px;">&nbsp;</div></td>
        <td class="percent text-right" title="{$type->percent|number_format:8}%">{$type->percent|number_format:2}</td>
      </tr>
      {foreach $records[$type->id] item=rowData name=foo}
        {if $smarty.foreach.foo.index < 100}
          <tr class="t t-{$category->id}-{$type->id} x-{$category->id}-{$type->id} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
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
      {if $type->variantCount > 100}
        <tr class="t t-{$category->id}-{$type->id} text-centered {$type->type}">
          <td colspan="8">
            {foreach from=$type->pages item=page}
              <a class="clickMore clickMore-{$category->id}-{$type->id}"
                 {if $page == 0}style="font-weight: bold"{/if}
                 id="clickMore-{$category->id}-{$type->id}-{$page}"
                 data-id="{$category->id}-{$type->id}"
                 data-page="{$category->id}-{$type->id}-{$page}"
                 href="?tab=issues&ajax=1&action=ajaxIssue&categoryId={$category->id}&typeId={$type->id}&page={$page}">[{$page+1}]</a>
            {/foreach}
          </td>
        </tr>
      {/if}
    {/foreach}
  {/foreach}
  </tbody>
</table>
