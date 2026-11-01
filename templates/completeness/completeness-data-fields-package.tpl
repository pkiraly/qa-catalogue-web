{foreach from=$tags key=tagName item=dataField}
  {assign var="tag" value=$dataField['tag']}
  <tr class="field-level">
    <td colspan="2" class="field-level tag" id="completeness-{$tag->websafeTag}">
      <a href="#" class="trigger" data-id="completeness-{$tag->websafeTag}"
         title="Show subfields"><i class="fa fa-folder-closed"></i></a>
      {* field query link *}
      {if (isset($tag->solrCountField))}
        <a href="{$controller->createFieldQueryLink($tag)}" title="{_t('Search records having this field!')}"><i class="fa fa-search"></i></a>
      {/if}
      {* field documentation link *}
      {if !empty($tag->url)}
         <a href="{$tag->url}" title="{_t('Go to the documentation of the field!')}" target="_blank">{$tag->extendedTag}</a>
         {if !empty($tag->label)} &mdash; {$tag->label}{/if}
      {else}
        {$tagName}
      {/if}
    </td>
    {include 'completeness/completeness-numbers.tpl'}
  </tr>
  {foreach from=$dataField['subfields'] item=subfield}
    {* assign var="record" value=$subfield *}
    <tr class="subfield-level completeness-{$subfield->websafeTag}">
      <td class="path" id="completeness-{$subfield->path}">
        {if $subfield->isLeader || $subfield->isComplexControlField || !$subfield->isField
            || strpos($subfield->path, '$') !== false}
          {if isset($subfield->solr) && !empty($subfield->solr)}
            <a href="{$controller->queryLink($subfield)}">
              {if $subfield->isComplexControlField || $subfield->isLeader}
                {$subfield->complexPosition}
              {elseif preg_match('/ind[12]$/', $subfield->path)}
                {$catalogue->getSubfield($subfield->path)}
              {else}
                {$catalogue->getSubfield($subfield->path)}
              {/if}
            </a>
          {elseif $subfield->isComplexControlField || $subfield->isLeader}
            {$subfield->complexPosition}
          {else}
            {$catalogue->getSubfield($subfield->path)}
          {/if}
        {/if}
      </td>
      <td class="subfield">{if property_exists($subfield, 'subfield')}{$subfield->subfield}{/if}</td>
      {include 'completeness/completeness-numbers.tpl'}
    </tr>
  {/foreach}
{/foreach}
