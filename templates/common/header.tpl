<h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
<p>
  <i class="fa fa-book" aria-hidden="true"></i>
  <a href="{$catalogue->getUrl()}" target="_blank">{$catalogue->getLabel()}</a>
  &nbsp; &nbsp; {if $lastUpdate != ''}<span class="last-update-info">(last data update: <span id="last-update">{$lastUpdate}</span>)</span>{/if}
  &nbsp; &nbsp; <span class="last-update-info">number of records: <strong>{$count|number_format}</strong></span>
</p>

