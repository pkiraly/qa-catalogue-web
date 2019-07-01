<h3>Classification schemes</h3>

<table>
  <thead>
    <tr>
      <th>Location</th>
      <th>Classification scheme</th>
      <th>Number of instances</th>
    </tr>
  </thead>
  <tbody>
    {assign var=previous value=""}
    {foreach $records as $record}
      {if $previous != $record->field}
        <tr>
          <td colspan="3"><h4>{$record->field} &mdash; {$fields[$record->field]}</h4></td>
        </tr>
      {/if}
      <tr>
        <td>{$record->location}</td>
        <td>
          {if (isset($record->facet) && isset($record->q))}
            <a href="#" class="term-link" data-facet="{$record->facet}" data-query="{$record->q}">{$record->scheme}</a>
          {else}
            {$record->scheme}
          {/if}
        </td>
        <td class="text-right">{$record->count|number_format}</td>
      </tr>
      {assign var=previous value=$record->field}
    {/foreach}
  </tbody>
</table>
