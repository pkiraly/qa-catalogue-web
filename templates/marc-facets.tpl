{foreach $facets as $facetName => $values}
  <div id="{$facetName}" class="facet-block">
    <h4>{getFacetLabel($facetName)}</h4>
    {assign var=offsetName value="f.{$facetName}.facet.offset"}
    {if isset($params->$offsetName)}
      {assign var=offset value="{$params->$offsetName}"}
    {else}
      {assign var=offset value=0}
    {/if}
    <ul>
      {foreach $values as $term => $count}<li><a href="#" class="facet-term">{$term}</a> ({$count})</li>{/foreach}
      {if count(get_object_vars($values)) >= 10 || $offset > 0}
        <li>
          {if $offset > 0}
            <a class="facet-up" href="#" data-field="{$facetName}" data-offset="{$offset}">
              <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
            </a>
          {/if}
          more
          {if count(get_object_vars($values)) >= 10}
            <a class="facet-down" href="#" data-field="{$facetName}" data-offset="{$offset}">
              <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
            </a>
          {/if}
        </li>
      {/if}
    </ul>
  </div>
{/foreach}
