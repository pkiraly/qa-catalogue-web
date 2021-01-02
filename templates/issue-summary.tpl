<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">records without issues</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">with</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: {ceil($topStatistics[0]->percent * 5)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$topStatistics[0]->records|number_format:0}
    ({$topStatistics[0]->percent|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics[1]->records|number_format:0}
    ({$topStatistics[1]->percent|number_format:2}%)
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
  <div style="width: {ceil((100 - $topStatistics[2]->percent) * 5)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$total - $topStatistics[2]->records|number_format:0}
    ({(100 - $topStatistics[2]->percent)|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics[2]->records|number_format:0}
    ({$topStatistics[2]->percent|number_format:2}%)
  </div>
</div>

<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames item=field}
        <th {if in_array($field, ['instances', 'records'])}class="text-right"{/if}>{if field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
  {foreach $categories key=index item=category name=categories}
    <tr class="category-header {$category->category}">
      <td colspan="3" class="category">
        <span class="category">{$category->category}</span> level issues
      </td>
      <td class="count">{$category->instances|number_format}</td>
      <td class="count">{$category->records|number_format}</td>
    </tr>
    {foreach $category->types item=typeId name=types}
      {assign var="type" value=$types[$typeId]}
      <tr class="type-header {$type->type}">
        <td colspan="3" class="type">
          <span class="type">{$type->type}</span> ({$type->variantCount} variants)
          <a href="javascript:openType('{$category->id}-{$type->id}')">[+]</a>
        </td>
        <td class="count">{$type->instances|number_format}</td>
        <td class="count">{$type->records|number_format}</td>
      </tr>
      {foreach $records[$type->id] item=rowData name=foo}
        {if $smarty.foreach.foo.index < 100}
          <tr class="t t-{$category->id}-{$type->id} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
            <td class="path">{$rowData->path}</td>
            <td class="message">
              {if preg_match('/^ +$/', $rowData->message)}"{$rowData->message}"{else}{$rowData->message}{/if}
            </td>
            <td class="url">
              <a href="{showMarcUrl($rowData->url)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
            </td>
            <td class="count instances">
              <a href="#" data-id="{$rowData->id}" data-type="{$type->type}" data-path="{$rowData->path}"
                 data-message="{$rowData->message}">{$rowData->instances|number_format}</a>
            </td>
            <td class="count records">
              <a href="#" data-id="{$rowData->id}" data-type="{$type->type}" data-path="{$rowData->path}"
                 data-message="{$rowData->message}" class="search">{$rowData->records|number_format}</a>
              <a href="#" data-id="{$rowData->id}" data-type="{$type->type}" data-path="{$rowData->path}"
                 data-message="{$rowData->message}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
              <a href="#" data-id="{$rowData->id}" data-type="{$type->type}" data-path="{$rowData->path}"
                 data-message="{$rowData->message}" class="list"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
            </td>
          </tr>
        {/if}
      {/foreach}
      {if $type->variantCount > 100}
        <tr class="t t-{$category->id}-{$type->id} text-centered {$type->type}">
          <td colspan="4">more</td>
        </tr>
      {/if}
    {/foreach}
  {/foreach}
  </tbody>
</table>
