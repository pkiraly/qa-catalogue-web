<table>
  <thead>
    <tr>
      <th>tags</th>
      <th>label</th>
      <th></th>
      <th class="text-right">count</th>
      <th class="text-right">percent</th>
    </tr>
  </thead>
  <tbody>
    {foreach $records as $record}
      <tr>
        <td>{$record->name}</td>
        <td>{if ($record->label != 'null')}{$record->label}{/if}</td>
        <td class="chart"><div style="width: {ceil($record->percent * 2)}px;">&nbsp;</div></td>
        <td class="text-right">{$record->count}</td>
        <td class="text-right">{$record->percent|number_format:2}%</td>
      </tr>
    {/foreach}
  </tbody>
</table>
