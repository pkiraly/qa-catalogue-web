<h3>Classification schemes</h3>

<table>
  <thead>
    <tr>
      <th>Field</th>
      <th>Classification scheme</th>
      <th>Number of instances</th>
    </tr>
  </thead>
  <tbody>
    {assign var=previous value=""}
    {foreach $records as $record}
      <tr>
        <td>{if $previous != $record->field}{$record->field}{/if}</td>
        <td>{$record->scheme}</td>
        <td class="text-right">{$record->count}</td>
      </tr>
      {assign var=previous value=$record->field}
    {/foreach}
  </tbody>
</table>