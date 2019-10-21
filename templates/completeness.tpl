<table>
  <thead>
    <tr class="first">
      <th colspan="3"></th>
      <th colspan="2" class="with-border">records</th>
      <th colspan="5" class="with-border">occurences</th>
    </tr>
    <tr class="second">
      <th class="left">path</th>
      <th class="left">label</th>
      <th class="left"></th>
      <th class="bordered-left">count</th>
      <th>%</th>
      <th>count</th>
      <th>min</th>
      <th>max</th>
      <th>mean</th>
      <th class="bordered-right">stddev</th>
    </tr>
  </thead>
  <tbody>
    {assign var=previousPackage value=""}
    {assign var=previousTag value=""}
    {foreach $records as $record}
      {if $previousPackage != $record->package}
        <tr>
          <td colspan="5" class="package">{$record->package}</td>
        </tr>
        {assign var=previousPackage value="{$record->package}"}
      {/if}
      {if $previousTag != $record->tag}
        <tr>
          <td colspan="5" class="tag">{$record->path|substr:0:3} &mdash; {$record->tag}</td>
        </tr>
        {assign var=previousTag value="{$record->tag}"}
      {/if}
      {assign var=percent value="{$record->{'number-of-record'} * 100 / $max}"}
      <tr>
        <td class="path">
          <a href="javascript:searchForField('{$record->solr}')">{$record->path|substr:3}</a>
        </td>
        <td class="subfield">{$record->subfield}</td>
        <td class="chart"><div style="width: {ceil($percent * 2)}px;">&nbsp;</div></td>
        <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
        <td class="percent-of-record">{$percent|number_format:2}%</td>
        <td class="number-of-instances">{$record->{'number-of-instances'}}</td>
        <td class="min">{$record->min}</td>
        <td class="max">{$record->max}</td>
        <td class="mean">{$record->mean}</td>
        <td class="stddev">{$record->stddev}</td>
      </tr>
    {/foreach}
  </tbody>
</table>
