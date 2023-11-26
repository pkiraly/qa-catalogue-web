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
      <th colspan="2" class="with-border">{_('records')}</th>
      <th colspan="5" class="with-border">{_('occurences')}</th>
    </tr>
    <tr class="second">
      <th class="left path"></th>
      <th class="left subfield"></th>
      <th class="left chart"></th>
      <th class="terms"></th>
      <th class="number-of-record">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'number-of-record')}">{_('count')}</a>
      </th>
      <th class="percent-of-record">%</th>
      <th class="number-of-instances">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'number-of-instances')}">{_('count')}</a>
      </th>
      <th class="min">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'min')}">{_('min')}</a>
      </th>
      <th class="max">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'max')}">{_('max')}</a>
      </th>
      <th class="mean">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'mean')}">⌀</a>
      </th>
      <th class="stddev">
        <a href="?tab=completeness{$controller->getTabSpecificParameters('sort', 'stddev')}">σ</a>
      </th>
    </tr>
  </thead>
  <tbody>
    {if $sort == ''}
      {foreach from=$records key=packageId item=tags name=packages}
        <tr{if !$smarty.foreach.packages.first} class="padded"{/if}>
          <td colspan="11" class="package" id="package-{$packageId}">
            {$packageIndex[$packageId]}
          </td>
        </tr>
        {if $packageId == 0}
          {include 'completeness/completeness-control-fields-package.tpl'}
        {else}
          {include 'completeness/completeness-data-fields-package.tpl'}
        {/if}
      {/foreach}
    {else}
      <tr><td colspan="5">{_('sorted')}</td></tr>
      {foreach from=$records item=record}
        <tr>
          <td class="path" id="completeness-{$record->path}">
            {if isset($record->solr) && !empty($record->solr)}
              <a href="{$controller->queryLink($record)}">
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
              <a href="{$controller->termsLink($record)}"><i class="fa fa-list-ol"></i></a>
            {/if}
          </td>
          <td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
          <td class="percent-of-record">{$record->percent|number_format:2}</td>
          <td class="number-of-instances">{$record->{'number-of-instances'}|number_format}</td>
          <td class="min">{$record->min}</td>
          <td class="max">{if $record->max != $record->min}{$record->max}{/if}</td>
          <td class="mean">{if $record->max != $record->min}{$record->mean}{/if}</td>
          <td class="stddev">{if $record->max != $record->min}{$record->stddev}{/if}</td>
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
