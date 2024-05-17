<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">{_('records without issues')}</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">{_('with')}</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: {ceil($topStatistics->statistics[1]->goodPercent * 5)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$topStatistics->statistics[1]->good|number_format:0}
    ({$topStatistics->statistics[1]->goodPercent|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics->statistics[1]->bad|number_format:0}
    ({$topStatistics->statistics[1]->badPercent|number_format:2}%)
  </div>
</div>

<p>{_('excluding undefined field issues')}</p>
<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">{_('records without issues')}</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">{_('with')}</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: {ceil($topStatistics->statistics[2]->goodPercent * 5)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$topStatistics->statistics[2]->good|number_format:0} ({($topStatistics->statistics[2]->goodPercent)|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$topStatistics->statistics[2]->bad|number_format:0} ({$topStatistics->statistics[2]->badPercent|number_format:2}%)
  </div>
</div>

{if !empty($categories)}
  <table id="issues-table">
    <thead>
      <tr>
        {foreach from=$fieldNames item=field}
          {if in_array($field, ['instances', 'records'])}
            <th class="text-right">{_($field)}</th>
          {else}
            <th></th>
          {/if}
        {/foreach}
        <th></th>
        <th></th>
        <th>%</th>
      </tr>
    </thead>
    <tbody>
    {foreach from=$categories key=index item=category name=categories}
      <tr class="category-header {$category->category}{if !$smarty.foreach.categories.first} padded{/if}">
        <td colspan="3" class="category">
          {_t('<span class="category">%s</span> level issues', _($category->category))}
        </td>
        <td class="count">{$category->instances|number_format}</td>
        <td class="count">{$category->records|number_format}</td>
        <td class="actions">
          <a href="{$controller->queryLink('categoryId:'|cat:$category->id)}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
          <a href="{$controller->downloadLink('categoryId='|cat:$category->id)})" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
        </td>
        <td class="chart"><div style="width: {ceil($category->ratio * 200)}px;">&nbsp;</div></td>
        <td class="percent text-right" title="{$category->percent|number_format:8}%">{$category->percent|number_format:2}</td>
      </tr>
      {foreach from=$category->types item=typeId name=types}
        {assign var="type" value=$types[$typeId]}
        <tr class="type-header {$type->type} h-{$category->id}-{$type->id}">
          <td colspan="3" class="type">
            <span class="type">{_($type->type)}</span> ({_t('%d variants', $type->variantCount)})
            <a href="javascript:openType('{$category->id}-{$type->id}')">[+]</a>
          </td>
          <td class="count">{$type->instances|number_format}</td>
          <td class="count">{$type->records|number_format}</td>
          <td class="actions">
            <a href="{$controller->queryLink('typeId:'|cat:$typeId)}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
            <a href="{$controller->downloadLink('typeId='|cat:$typeId)}" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
          </td>
          <td class="chart"><div style="width: {ceil($type->ratio * 200)}px;">&nbsp;</div></td>
          <td class="percent text-right" title="{$type->percent|number_format:8}%">{$type->percent|number_format:2}</td>
        </tr>
        {include file="issues/issue-list.tpl"
                 records=$records[$type->id]
                 categoryId=$category->id
                 typeId=$type->id
                 pages=$type->pages
                 recordCount=$type->variantCount}
      {/foreach}{* types *}
    {/foreach}{* categories *}
    </tbody>
  </table>
{/if}