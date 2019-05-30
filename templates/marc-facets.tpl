{foreach $facets as $facetName => $values}
  <div id="{$facetName}" class="facet-block">
    <h4>{getFacetLabel($facetName)}</h4>
    {assign var=offset value="f.{$facetName}.facet.offset"}
    <ul>
      {foreach $values as $term => $count}<li><a href="#" class="facet-term">{$term}</a> ({$count})</li>{/foreach}
      {if count(get_object_vars($values)) >= 10 || (isset($params->$offset) && $params->$offset > 0)}
        <li>
          {if isset($params->$offset) && $params->$offset > 0}
            <a class="facet-up" href="#" data-field="{$facetName}"
               data-offset="{if isset($params->$offset)}{$params->$offset}{else}0{/if}">
              <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
            </a>
          {/if}
          more
          {if count(get_object_vars($values)) >= 10}
            <a class="facet-down" href="#" data-field="{$facetName}"
               data-offset="{if isset($params->$offset)}{$params->$offset}{else}0{/if}">
              <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
            </a>
          {/if}
        </li>
      {/if}
    </ul>
  </div>
{/foreach}
