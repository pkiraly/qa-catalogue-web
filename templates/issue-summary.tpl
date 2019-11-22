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
    ({($topStatistics[0]->percent * 100)|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics[1]->records|number_format:0}
    ({($topStatistics[1]->percent * 100)|number_format:2}%)
  </div>
</div>

<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames as $field}
        <th {if in_array($field, ['instances', 'records'])}class="text-right"{/if}>{if field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
  {foreach $categories key=category item=types name=categories}
    <tr class="category-header {$category}">
      <td colspan="3" class="category">
        <span class="category">{$category}</span> level issues
      </td>
      <td class="count">{$categoryStatistics[$category]->instances|number_format}</td>
      <td class="count">{$categoryStatistics[$category]->records|number_format}</td>
    </tr>
    {foreach $types item=type name=types}
      <tr class="type-header {$type}">
        <td colspan="3" class="type">
          <span class="type">{$type}</span> ({$typeCounter[$type]->variations} variants)
          <a href="javascript:openType('{$smarty.foreach.categories.index}-{$smarty.foreach.types.index}')">[+]</a>
        </td>
        <td class="count">{$typeStatistics[$type]->instances|number_format}</td>
        <td class="count">{$typeStatistics[$type]->records|number_format}</td>
      </tr>
      {foreach $records[$type] item=rowData name=foo}
        {if $smarty.foreach.foo.index < 100}
          <tr class="t t-{$smarty.foreach.categories.index}-{$smarty.foreach.types.index} {if $smarty.foreach.foo.index % 2 == 1}odd{/if}">
            <td class="path">{$rowData->path}</td>
            <td class="message">
              {if preg_match('/^ +$/', $rowData->message)}"{$rowData->message}"{else}{$rowData->message}{/if}
            </td>
            <td class="url">
              <a href="{showMarcUrl($rowData->url)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
            </td>
            <td class="count">
              <a href="#" data-id="{$rowData->id}" data-type="{$type}" data-path="{$rowData->path}"
                 data-message="{$rowData->message}">{$rowData->instances|number_format}</a>
            </td>
            <td class="count">
              <a href="#" data-id="{$rowData->id}" data-type="{$type}" data-path="{$rowData->path}"
                 data-message="{$rowData->message}">{$rowData->records|number_format}</a>
            </td>
          </tr>
        {/if}
      {/foreach}
      {if $typeCounter[$type]->variations > 100}
        <tr class="t t-{$smarty.foreach.types.index} text-centered {$type}">
          <td colspan="4">more</td>
        </tr>
      {/if}
    {/foreach}
  {/foreach}
  </tbody>
</table>

