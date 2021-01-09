<h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
<p>
  <i class="fa fa-book" aria-hidden="true"></i>
  <a href="{$catalogue->getUrl()}" target="_blank">{$catalogue->getLabel()}</a>
  <span class="header-info">
    {if $lastUpdate != ''}
      &nbsp; &nbsp; last data update: <strong>{$lastUpdate}</strong>)</span>
    {/if}
    &nbsp; &nbsp; <span class="last-update-info">number of records: <strong>{$count|number_format}</strong>
  </span>
</p>

