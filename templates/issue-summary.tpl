<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames as $field}
        <th>{if field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
    {foreach $types item=type name=types}
      <tr class="type-header {$type}">
        <td colspan="3" class="type"><span class="type">{$type}</span> ({$typeCounter[$type]->variations} variants)
          <a href="javascript:openType('{$smarty.foreach.types.index}')">[+]</a></td>
        <td class="count">{$typeCounter[$type]->count}</td>
      </tr>
      {foreach $records[$type] item=rowData name=foo}
        {if $smarty.foreach.foo.index < 100}
          <tr class="t t-{$smarty.foreach.types.index}">
            <td class="path">{$rowData->path}</td>
            <td class="message">
              {if preg_match('/^ +$/', $rowData->message)}"{$rowData->message}"{else}{$rowData->message}{/if}
            </td>
            <td class="url">
              <a href="{showMarcUrl($rowData->url)}" target="_blank"><i class="fa fa-info" aria-hidden="true"></i></a>
            </td>
            <td class="count">
              <a href="#" data-id="{$rowData->id}" data-type="{$type}"
                 data-path="{$rowData->path}" data-message="{$rowData->message}">{$rowData->count|number_format}</a>
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
  </tbody>
</table>

