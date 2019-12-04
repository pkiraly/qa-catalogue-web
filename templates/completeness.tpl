<table>
  <colgroup>
    <col>
    <col>
    <col>
    <col>
    <col>
    <col style="border-right: 1px solid #cccccc;">
    <col>
    <col>
    <col>
    <col>
    <col>
  </colgroup>
  <thead>
    <tr class="first">
      <th colspan="3"></th>
      <th></th>
      <th colspan="2" class="with-border">records</th>
      <th colspan="5" class="with-border">occurences</th>
    </tr>
    <tr class="second">
      <th class="left path">path</th>
      <th class="left subfield">label</th>
      <th class="left chart"></th>
      <th class="terms">terms</th>
      <th class="number-of-record">count</th>
      <th class="percent-of-record">%</th>
      <th class="number-of-instances">count</th>
      <th class="min">min</th>
      <th class="max">max</th>
      <th class="mean">mean</th>
      <th class="stddev">stddev</th>
    </tr>
  </thead>
  <tbody>
    {assign var=previousPackage value=""}
    {assign var=previousTag value=""}
    {foreach $records as $record}
      {if $previousPackage != $record->package}
        <tr>
          <td colspan="4" class="package">{$record->package}</td>
        </tr>
        {assign var=previousPackage value="{$record->package}"}
      {/if}
      {if $previousTag != $record->tag}
        <tr>
          <td colspan="4" class="tag">{$record->path|substr:0:3} &mdash; {$record->tag}</td>
        </tr>
        {assign var=previousTag value="{$record->tag}"}
      {/if}
      {assign var=percent value="{$record->{'number-of-record'} * 100 / $max}"}
      <tr>
        <td class="path" id="completeness-{$record->path}">
          {if isset($record->solr)}
            <a href="javascript:searchForField('{$record->solr}')">{$record->path|substr:3}</a>
          {else}
            {$record->path|substr:3}
          {/if}
        </td>
        <td class="subfield">{$record->subfield}</td>
        <td class="chart"><div style="width: {ceil($percent * 2)}px;">&nbsp;</div></td>
        <td class="terms">
          {if isset($record->solr)}
            <a href="#" class="term-link facet2" data-facet="{$record->solr}" data-query="*:*"
               data-scheme="{$record->solr}"><i class="fa fa-list-ol"></i></a>
          {/if}
        </td>
        <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
        <td class="percent-of-record">{$percent|number_format:2}%</td>
        <td class="number-of-instances">{$record->{'number-of-instances'}|number_format}</td>
        <td class="min">{$record->min}</td>
        <td class="max">{$record->max}</td>
        <td class="mean">{$record->mean}</td>
        <td class="stddev">{$record->stddev}</td>
      </tr>
    {/foreach}
  </tbody>
</table>
