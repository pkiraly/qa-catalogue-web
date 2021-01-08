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
    {foreach $packages as $package}
      {if !isset($package->iscoretag) || $package->iscoretag}
        <tr>
          <td>{$package->name}</td>
          <td>{if ($package->label != 'null')}{$package->label}{/if}</td>
          <td class="chart"><div style="width: {ceil($package->percent * 2)}px;">&nbsp;</div></td>
          <td class="text-right">{$package->count|number_format}</td>
          <td class="text-right">{$package->percent|number_format:2}%</td>
        </tr>
      {/if}
    {/foreach}
    {if $hasNonCoreTags}
      <tr>
        <td colspan="5"><h4>Fields defined in extensions of MARC</h4></td>
      </tr>
      {foreach $packages as $package}
        {if isset($package->iscoretag) && !$package->iscoretag}
          <tr>
            <td>{$package->name}</td>
            <td>{if ($package->label != 'null')}{$package->label}{/if}</td>
            <td class="chart"><div style="width: {ceil($package->percent * 2)}px;">&nbsp;</div></td>
            <td class="text-right">{$package->count|number_format}</td>
            <td class="text-right">{$package->percent|number_format:2}%</td>
          </tr>
        {/if}
      {/foreach}
    {/if}
  </tbody>
</table>
