<tr class="subfield-level completeness-{$record->websafeTag}">
  <td class="path" id="completeness-{$record->path}">
    {if $record->isLeader || $record->isComplexControlField || !$record->isField || strpos($record->path, '$') !== false}
      {if isset($record->solr) && !empty($record->solr)}
        <a href="{$controller->queryLink($record)}">
          {if $record->isComplexControlField || $record->isLeader}
            {$record->complexPosition}
          {elseif preg_match('/ind[12]$/', $record->path)}
            {$catalogue->getSubfield($record->path)}
          {else}
            {$catalogue->getSubfield($record->path)}
          {/if}
        </a>
        {elseif $record->isComplexControlField || $record->isLeader}
          {$record->complexPosition}
        {else}
          {$catalogue->getSubfield($record->path)}
        {/if}
      {/if}
  </td>
  <td class="subfield">{$record->subfield}</td>
  {include 'completeness/completeness-numbers.tpl'}
</tr>
