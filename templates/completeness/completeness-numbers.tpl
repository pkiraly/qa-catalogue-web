<td class="chart"><div style="width: {ceil($record->percent * 2)}px;">&nbsp;</div></td>
<td class="terms">
  {if isset($record->solr) && !empty($record->solr)}
    <a href="{$controller->termsLink($record)}" title="{_('List of terms')}"><img src="styles/list.png" width="20" height="20"></a>
    <a href="{$controller->timelineLink($record)}" title="{_('Data element utilisation timeline')}"><i class="fa-solid fa-chart-line"></i></a>
  {/if}
</td>
<td class="number-of-record">{$record->{'number-of-record'}|number_format}</td>
<td class="percent-of-record">{$record->percent|number_format:2}</td>
<td class="number-of-instances">{$record->{'number-of-instances'}|number_format}</td>
<td class="min">{$record->min}</td>
<td class="max">{if $record->max != $record->min}{$record->max}{/if}</td>
<td class="mean">{if $record->max != $record->min}{$record->mean}{/if}</td>
<td class="stddev">{if $record->max != $record->min}{$record->stddev}{/if}</td>
