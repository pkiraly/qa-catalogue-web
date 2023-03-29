<div class="marc-human" id="marc-human-{$id}">
  {if isset($doc->record_sni)}
    <table>
      {foreach from=$record->resolvePicaFields() item=row}
        <tr {if !empty($row[0])}class="tag"{/if}>
          {foreach from=$row item=cell}
            {if is_object($cell)}
              {if isset($cell->url)}
                <td><a href="{$cell->url}" target="_blank">{$cell->text}</a></td>
              {else}
                <td colspan="{$cell->span}" class="tag-title">{$cell->text}</td>
              {/if}
            {else}
              <td>{$cell}</td>
            {/if}
          {/foreach}
        </tr>
      {/foreach}
    </table>
  {/if}
</div>
