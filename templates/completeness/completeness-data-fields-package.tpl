{foreach from=$tags key=tagName item=dataField}
  {assign var="record" value=$dataField['tag']}
  <tr class="field-level">
    <td colspan="2" class="field-level tag" id="completeness-{$record->websafeTag}">
      <a href="#" class="trigger" data-id="completeness-{$record->websafeTag}" title="Show subfields"><i class="fa fa-folder-closed"></i></a>
      {$tagName}
    </td>
    {include 'completeness/completeness-numbers.tpl'}
  </tr>
  {foreach from=$dataField['subfields'] item=subfield}
    {assign var="record" value=$subfield}
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
  {/foreach}
{/foreach}
