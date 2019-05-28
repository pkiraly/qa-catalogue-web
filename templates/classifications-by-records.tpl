<h3>How many records have classifications?</h3>

<table>
  <thead>
    <tr>
      <th>Classification is available?</th>
      <th>number of records</th>
    </tr>
  </thead>
  <tbody>
    {foreach $records as $record}
      <tr>
        <td>{$record->{'records-with-classification'}}</td>
        <td class="text-right">{$record->count}</td>
      </tr>
    {/foreach}
  </tbody>
</table>