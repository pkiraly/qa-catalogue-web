<div class="marc-details" id="marc-details-{$id}">
  {if isset($doc->record_sni)}
    <table id="marc-details-{$id}-table">
      {foreach from=$record->getMarcFields('UNIMARC') item=row}
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
    </table>
  {/if}
</div>
