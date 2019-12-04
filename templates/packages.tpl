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
      {if !isset($record->iscoretag) || $record->iscoretag}
        <tr>
          <td>{$record->name}</td>
          <td>{if ($record->label != 'null')}{$record->label}{/if}</td>
          <td class="chart"><div style="width: {ceil($record->percent * 2)}px;">&nbsp;</div></td>
          <td class="text-right">{$record->count|number_format}</td>
          <td class="text-right">{$record->percent|number_format:2}%</td>
        </tr>
      {/if}
    {/foreach}
    <tr>
      <td colspan="5"><h4>Tags defined in extensions of MARC</h4></td>
    </tr>
    {foreach $records as $record}
      {if isset($record->iscoretag) && !$record->iscoretag}
        <tr>
          <td>{$record->name}</td>
          <td>{if ($record->label != 'null')}{$record->label}{/if}</td>
          <td class="chart"><div style="width: {ceil($record->percent * 2)}px;">&nbsp;</div></td>
          <td class="text-right">{$record->count|number_format}</td>
          <td class="text-right">{$record->percent|number_format:2}%</td>
        </tr>
      {/if}
    {/foreach}
  </tbody>
</table>
