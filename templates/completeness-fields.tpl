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
      <th class="number-of-record">
        <a href="?tab=completeness&type={urlencode($selectedType)}{if $sort != 'number-of-record'}&sort=number-of-record{/if}">count</a>
      </th>
      <th class="percent-of-record">%</th>
      <th class="number-of-instances">
        <a href="?tab=completeness&type={urlencode($selectedType)}{if $sort != 'number-of-instances'}&sort=number-of-instances{/if}">count</a>
      </th>
      <th class="min">
        <a href="?tab=completeness&type={urlencode($selectedType)}{if $sort != 'min'}&sort=min{/if}">min</a>
      </th>
      <th class="max">
        <a href="?tab=completeness&type={urlencode($selectedType)}{if $sort != 'max'}&sort=max{/if}">max</a>
      </th>
      <th class="mean">
        <a href="?tab=completeness&type={urlencode($selectedType)}{if $sort != 'mean'}&sort=mean{/if}">mean</a>
      </th>
      <th class="stddev">
        <a href="?tab=completeness&type={urlencode($selectedType)}{if $sort != 'stddev'}&sort=stddev{/if}">stddev</a>
      </th>
    </tr>
  </thead>
  <tbody>
    {if $sort == ''}
      {foreach $records as $packageId => $tags name=packages}
        <tr{if !$smarty.foreach.packages.first} class="padded"{/if}>
          <td colspan="11" class="package" id="package-{$packageId}">{$packageIndex[$packageId]}</td>
        </tr>
        {foreach $tags as $tagName => $records}
          <tr>
            <td colspan="4" class="tag" id="completeness-{$catalogue->getTag($tagName)}">{$tagName}</td>
          </tr>
          {assign var=prevComplexType value=""}
          {foreach $records as $record}
            {assign var=percent value="{$record->{'number-of-record'} * 100 / $max}"}
            {if $record->isComplexControlField && $prevComplexType != $record->complexType}
              <tr>
                <td colspan="5" style="text-align: left">{$record->complexType}</td>
              </tr>
            {/if}
            <tr>
              <td class="path" id="completeness-{$record->path}">
                {if isset($record->solr) && !empty($record->solr)}
                  <a href="?tab=data&query=&query={if $selectedType == 'all'}*:*{else}type_ss:%22{$selectedType|urlencode}%22{/if}&filters[]={$record->solr}:*">
                    {if $record->isComplexControlField || $record->isLeader}
                      {$record->complexPosition}
                    {elseif preg_match('/ind[12]$/', $record->path)}
                      {$catalogue->getSubfield($record->path)}
                    {else}
                      {$catalogue->getSubfield($record->path)}
                    {/if}
                  </a>
                {elseif $record->isComplexControlField || $record->isLeader}
                  {$record->complexPosition}
                {else}
                  {$catalogue->getSubfield($record->path)}
                {/if}
              </td>
              <td class="subfield">{$record->subfield}</td>
              <td class="chart"><div style="width: {ceil($percent * 2)}px;">&nbsp;</div></td>
              <td class="terms">
                {if isset($record->solr) && !empty($record->solr)}
                  <a href="?tab=terms&facet={$record->solr}&query={if $selectedType == 'all'}*:*{else}type_ss:%22{$selectedType|urlencode}%22{/if}"><i class="fa fa-list-ol"></i></a>
                {/if}
              </td>
              <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
              <td class="percent-of-record">{$percent|number_format:2}</td>
              <td class="number-of-instances">{$record->{'number-of-instances'}|number_format}</td>
              <td class="min">{$record->min}</td>
              <td class="max">{$record->max}</td>
              <td class="mean">{$record->mean}</td>
              <td class="stddev">{$record->stddev}</td>
            </tr>
            {if $record->isComplexControlField}
              {assign var=prevComplexType value=$record->complexType}
            {/if}
          {/foreach}
        {/foreach}
      {/foreach}
    {else}
      <tr><td colspan="5">sorted</td></tr>
      {foreach $records as $record}
        {assign var=percent value="{$record->{'number-of-record'} * 100 / $max}"}
        <tr>
          <td class="path" id="completeness-{$record->path}">
            {if isset($record->solr) && !empty($record->solr)}
              <a href="?tab=data&query=&query={if $selectedType == 'all'}*:*{else}type_ss:%22{$selectedType|urlencode}%22{/if}&filters[]={$record->solr}:*">
                {if $record->isComplexControlField || $record->isLeader}
                  {$record->complexPosition}
                {elseif preg_match('/ind[12]$/', $record->path)}
                  {$catalogue->getSubfield($record->path)}
                {else}
                  {$catalogue->getSubfield($record->path)}
                {/if}
              </a>
            {elseif $record->isComplexControlField || $record->isLeader}
              {$record->complexPosition}
            {else}
              {$record->path}
            {/if}
          </td>
          <td class="subfield">{$record->subfield}</td>
          <td class="chart"><div style="width: {ceil($percent * 2)}px;">&nbsp;</div></td>
          <td class="terms">
            {if isset($record->solr) && !empty($record->solr)}
              <a href="?tab=terms&facet={$record->solr}&query={if $selectedType == 'all'}*:*{else}type_ss:%22{$selectedType|urlencode}%22{/if}"><i class="fa fa-list-ol"></i></a>
            {/if}
          </td>
          <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
          <td class="percent-of-record">{$percent|number_format:2}</td>
          <td class="number-of-instances">{$record->{'number-of-instances'}|number_format}</td>
          <td class="min">{$record->min}</td>
          <td class="max">{$record->max}</td>
          <td class="mean">{$record->mean}</td>
          <td class="stddev">{$record->stddev}</td>
        </tr>
      {/foreach}
    {/if}
  </tbody>
</table>
