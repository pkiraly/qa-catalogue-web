<h1><a href="." class="header-link"><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue</a> <span>{_('for analysing library data')}</span></h1>
<div class="row" style="margin-bottom: 1rem;">
  <div class="col-md-9">
    <i class="fa fa-book" aria-hidden="true"></i> <a href="{$catalogue->getUrl()}" target="_blank">{$catalogue->getLabel()}</a><br>
  <span class="header-info">
    {if $count > 0}
      &nbsp; &nbsp; {_('number of records')}: <strong>{$count|number_format}</strong>
    {/if}
    {if isset($lastUpdate) && $lastUpdate != ''}
      &nbsp; &nbsp; {_('last data update')}: <strong>{$lastUpdate}</strong>
    {/if}
    {if isset($analysisTimestamp) && !empty($analysisTimestamp)}
      &nbsp; &nbsp; {_('timestamp of analysis')}: <strong>{$analysisTimestamp}</strong>
    {/if}
  </span>
  </div>
  <div class="col-md-3 text-right">
    {foreach from=$languages key=language item=code name=languages}
      {if !$smarty.foreach.languages.first}|{/if}
      {if $lang == $language}
        {$language}
      {else}
        <a href="?{$controller->selectLanguage($language)}">{$language}</a>
      {/if}
    {/foreach}
  </div>
</div>

