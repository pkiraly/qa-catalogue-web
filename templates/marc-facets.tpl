{foreach from=$facets key=facetName item=values}
  {if count(get_object_vars($values)) > 0}
    {assign var="facet" value=$controller->createFacet($facetName, $values)}
    <div id="{$facetName}" class="facet-block">
      <div class="facet-name">
        <strong>{$controller->resolveSolrField($facetName)}</strong>
        <span class="terms-count" style="display: none">({_('number of distinct values')}: <strong id="terms-count"></strong>)</span>
      </div>
      <ul>
        {foreach from=$values key=term item=count}
          <li>
            <a href='{$facet->createLink($term)}' class="facet-term">{if preg_match('/(^\s|\s{2,}|\s$)/', $term)}"{preg_replace('/\s/', '&nbsp;', htmlspecialchars($term))}"{else}{htmlspecialchars($term)}{/if}</a>
            ({$count|number_format})
          </li>
        {/foreach}
        {if $facet->hasPrevList() || $facet->hasNextList()}
          <li>
            {if $facet->hasPrevList()}
              <a class="facet-up{if $ajaxFacet == 1} ajax-facet-navigation{/if}" href="{$facet->createPrevLink()}" data-field="{$facetName}">
                <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
              </a>
            {/if}
            more
            {if $facet->hasNextList()}
              <a class="facet-down{if $ajaxFacet == 1} ajax-facet-navigation{/if}" href="{$facet->createNextLink()}" data-field="{$facetName}">
                <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
              </a>
            {/if}
          </li>
        {/if}
      </ul>
    </div>
  {/if}
{/foreach}
