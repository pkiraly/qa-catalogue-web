{foreach $facets as $facetName => $values}
  {if count(get_object_vars($values)) > 0}
    {assign var="facet" value=$controller->createFacet($facetName, $values)}
    <div id="{$facetName}" class="facet-block">
      <div><strong>{$controller->resolveSolrField($facetName)}</strong></div>
      <ul>
        {foreach $values as $term => $count}
          <li><a href='{$facet->createLink($term)}' class="facet-term">{if preg_match('/(^\s|\s{2,}|\s$)/', $term)}"{preg_replace('/\s/', '&nbsp;', $term)}"{else}{$term}{/if}</a> ({$count|number_format})</li>
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
