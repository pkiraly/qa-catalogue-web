{foreach $facets as $facetName => $values}
  <div id="{$facetName}" class="facet-block">
    <h4>{getFacetLabel($facetName)}</h4>
    <ul>
      {foreach $values as $term => $count}<li><a href="#">{$term}</a> ({$count})</li>{/foreach}
    </ul>
  </div>
{/foreach}
