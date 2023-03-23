<table>
  <colgroup>
    <col>
    <col style="width: 25%; min-width: 25%; max-width: 25%;">
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
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'number-of-record')}">count</a>
      </th>
      <th class="percent-of-record">%</th>
      <th class="number-of-instances">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'number-of-instances')}">count</a>
      </th>
      <th class="min">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'min')}">min</a>
      </th>
      <th class="max">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'max')}">max</a>
      </th>
      <th class="mean">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'mean')}">mean</a>
      </th>
      <th class="stddev">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'stddev')}">stddev</a>
      </th>
    </tr>
  </thead>
  <tbody>
    {if $sort == ''}
      {foreach from=$records key=packageId item=tags name=packages}
        <tr{if !$smarty.foreach.packages.first} class="padded"{/if}>
          <td colspan="11" class="package" id="package-{$packageId}">{$packageIndex[$packageId]}</td>
        </tr>
        {foreach from=$tags key=tagName item=records}
          {if preg_match('/^(Leader|00[678])/', $tagName)}
            <tr class="field-level">
              <td colspan="11" class="tag" id="completeness-{$records[0]->websafeTag}">
                <a href="#" class="trigger" data-id="completeness-{$records[0]->websafeTag}" title="Show subfields"><i class="fa fa-folder-closed"></i></a>
                  {$tagName}
              </td>
            </tr>
          {/if}
          {assign var=prevComplexType value=""}
          {foreach from=$records item=record}
            {if $record->isComplexControlField && $prevComplexType != $record->complexType}
              <tr class="complex-type complex-type-level completeness-{$record->websafeTag}">
                <td colspan="11" style="text-align: left">{$record->complexType}</td>
              </tr>
            {/if}
            <tr class="{if $record->isField}field-level{else}subfield-level completeness-{$record->websafeTag}{/if}">
              {if $record->isField}
                <td colspan="2" class="field-level tag" id="completeness-{$record->websafeTag}">
                  <a href="#" class="trigger" data-id="completeness-{$record->websafeTag}" title="Show subfields"><i class="fa fa-folder-closed"></i></a>
                  {$tagName}
                </td>
              {else}
                <td class="path" id="completeness-{$record->path}">
                  {if $record->isLeader || $record->isComplexControlField || !$record->isField || strpos($record->path, '$') !== false}
                    {if isset($record->solr) && !empty($record->solr)}
                      <a href="{$controller->queryLink($record)}">
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
                  {/if}
                </td>
                <td class="subfield">{$record->subfield}</td>
              {/if}
              <td class="chart"><div style="width: {ceil($record->percent * 2)}px;">&nbsp;</div></td>
              <td class="terms">
                {if isset($record->solr) && !empty($record->solr)}
                  <a href="{$controller->termsLink($record)}"><img src="styles/list.png" width="20" height="20"></a>
                {/if}
              </td>
              <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
              <td class="percent-of-record">{$record->percent|number_format:2}</td>
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
      {foreach from=$records item=record}
        <tr>
          <td class="path" id="completeness-{$record->path}">
            {if isset($record->solr) && !empty($record->solr)}
              <a href="?tab=data&query=&query={if $selectedType == 'all'}*:*{else}type_ss:%22{$selectedType|urlencode}%22{/if}&filters[]={$record->solr}:*">
                {if $record->isComplexControlField || $record->isLeader}
                  {$record->path}
                {elseif preg_match('/ind[12]$/', $record->path)}
                  {$record->path}
                {else}
                  {$record->path}
                {/if}
              </a>
            {elseif $record->isComplexControlField || $record->isLeader}
              {$record->path}
            {else}
              {$record->path}
            {/if}
          </td>
          <td class="subfield">{$record->subfield}</td>
          <td class="chart"><div style="width: {ceil($record->percent * 2)}px;">&nbsp;</div></td>
          <td class="terms">
            {if isset($record->solr) && !empty($record->solr)}
              <a href="?tab=terms&facet={$record->solr}&query={if $selectedType == 'all'}*:*{else}type_ss:%22{$selectedType|urlencode}%22{/if}"><i class="fa fa-list-ol"></i></a>
            {/if}
          </td>
          <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
          <td class="percent-of-record">{$record->percent|number_format:2}</td>
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

<script>
var openedIcon = '<i class="fa fa-folder-open">';
var closedIcon = '<i class="fa fa-folder-closed">';

$('a.trigger').click(function (event) {
  event.preventDefault();
  var id = $(this).attr('data-id');
  $('tr.' + id).toggle();
  $(this).html($(this).html().includes('open') ? closedIcon : openedIcon);
});

var anchor = window.location.hash;
if (anchor != '') {
  var subfield = anchor.substring(1);
  var subfieldStartsAt = subfield.indexOf('$');
  var field = (subfieldStartsAt == -1) ? subfield : subfield.substring(0, subfieldStartsAt);
  $('tr.' + field).show();
  $('td#' + field + ' a').html(openedIcon);
}
</script>