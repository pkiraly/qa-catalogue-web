<div class="marc-labels">
  {if isset($doc->record_sni)}
    <table id="marc-labels-{$id}-table" class="marc-labels-table">
      <thead>
        <th class="tag"></th>
        <th class="subfield"></th>
        <th class="label"></th>
        <th class="ind"></th>
        <th class="value-label"></th>
      </thead>
      <tbody>
        {foreach from=$record->resolveMarcFields() item=row}
          <tr>
            {foreach from=$row item=cell}
              {if is_object($cell)}
                <td><a href="{$cell->url}" target="_blank">{$cell->text}</a></td>
              {else}
                <td>{$cell}</td>
              {/if}
            {/foreach}
          </tr>
        {/foreach}
      </tbody>
    </table>
  {/if}
</div>
