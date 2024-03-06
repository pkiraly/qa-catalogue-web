<table>
  <thead>
    <tr>
      <th>{_('Fields')}</th>
      <th></th>
      {if $hasTotalPackage}
        <th class="text-right">{_('fields')}</th>
        <th class="text-right">{_('pos./subf.')}</th>
      {/if}
      <th></th>
      <th class="text-right">{_('count')}</th>
      <th class="text-right">%</th>
    </tr>
  </thead>
  <tbody>
    {if $catalogue->getSchemaType() == 'MARC21'}
      <tr>
        <td colspan="{if $hasTotalPackage}7{else}5{/if}"><h4>Fields defined in MARC21</h4></td>
      </tr>
      {foreach from=$packages item=package}
        {if !isset($package->iscoretag) || $package->iscoretag}
          <tr class="is-core-tag"  id="groups-package-{$package->packageid}">
            <td><a href="#package-{$package->packageid}">{$package->name}</a></td>
            <td>{if ($package->label != 'null')}{$package->label}{/if}</td>
            {if $hasTotalPackage}
              <td class="text-right">{$package->fieldCount|number_format}</td>
              <td class="text-right">{$package->subfieldCount|number_format}</td>
            {/if}
            <td class="chart"><div style="width: {ceil($package->percent * 2)}px;">&nbsp;</div></td>
            <td class="text-right">{$package->count|number_format}</td>
            <td class="text-right">{$package->percent|number_format:2}</td>
          </tr>
        {/if}
      {/foreach}
    {/if}
    {if $hasNonCoreTags}
      {if $catalogue->getSchemaType() == 'MARC21'}
        <tr>
          <td colspan="{if $hasTotalPackage}7{else}5{/if}"><h4>Fields defined in extensions of MARC</h4></td>
        </tr>
      {/if}
      {foreach from=$packages item=package}
        {if isset($package->iscoretag) && !$package->iscoretag && $package->packageid != 'total'}
          <tr class="is-not-core-tag" id="groups-package-{$package->packageid}">
            <td><a href="#package-{$package->packageid}">{$package->name}</a></td>
            <td>{if ($package->label != 'null')}{$package->label}{/if}</td>
            {if $hasTotalPackage}
              <td class="text-right">{$package->fieldCount|number_format}</td>
              <td class="text-right">{$package->subfieldCount|number_format}</td>
            {/if}
            <td class="chart"><div style="width: {ceil($package->percent * 2)}px;">&nbsp;</div></td>
            <td class="text-right">{$package->count|number_format}</td>
            <td class="text-right">{$package->percent|number_format:2}</td>
          </tr>
        {/if}
      {/foreach}
    {/if}
    {if $hasTotalPackage}
      {foreach from=$packages item=package}
        {if $package->packageid === 'total'}
          <tr class="total" id="groups-package-{$package->packageid}">
            <td colspan="2"><b>{_('Total number of data elements')}</b></td>
            <td class="text-right align-text-bottom" style="vertical-align: bottom !important;">{$package->fieldCount|number_format}</td>
            <td class="text-right align-text-bottom" style="vertical-align: bottom !important;">{$package->subfieldCount|number_format}</td>
            <td class="chart"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
          </tr>
        {/if}
      {/foreach}
    {/if}
  </tbody>
</table>
