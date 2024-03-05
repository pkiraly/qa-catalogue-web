<h4>Representation in Solr index</h4>

<ul>
  {foreach from=$record->getAllSolrFields() item=field}
    <li>
      <span class="label">{$field->label}:</span>
      {foreach from=$field->value item=value name=values}
        {$value}{if !$smarty.foreach.values.last} &mdash; {/if}
      {/foreach}
    </li>
  {/foreach}
</ul>
