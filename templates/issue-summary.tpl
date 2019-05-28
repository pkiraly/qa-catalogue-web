<table id="issues-table">
  <thead>
    <tr>
      {foreach $fieldNames as $field}
        <th>{if field == 'message'}value/explanation{else}{$field}{/if}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
    {foreach $types as $type}
      <tr class="type-header {$type}">
        <td colspan="3">{$type} {count($records[$type])} variants</td>
        <td>{$typeCounter[$type]->count}</td>
      </tr>
      {foreach $records[$type] item=rowData name=foo}
        {if $smarty.foreach.foo.index < 100}
          {assign var=typeCounter value=1}
          <tr class="t t-{$typeCounter}">
            {foreach from=$rowData key=field item=content}
              <td class="{$field}">
                {if $field == 'count'}
                  {*   totalCount += parseInt(content) *}
                  <a href="#" data-type="{$type}" data-path="{$rowData->path}" data-message="{$rowData->message}">{$content}</a>
                {elseif $field == 'url'}
                  {if preg_match('/^http/', $content)}
                    <a href="{showMarcUrl($content)}" target="_blank">
                      <i class="fa fa-info" aria-hidden="true"></i></a>
                  {/if}
                {elseif $field == 'message'}
                  {if preg_match('/^ +$/', $content)}"{$content}"{else}{$content}{/if}
                {elseif $field == 'path'}
                  {$content}
                {/if}
              </td>
            {/foreach}
          </tr>
        {/if}
      {/foreach}
    {/foreach}
  </tbody>
</table>

