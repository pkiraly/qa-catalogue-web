{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>Terms</h2>
      {* <div id="terms-scheme" data-facet="{$facet}" data-query="{$termQuery}">{$label}</div> *}
      {if $scheme != ''}
        <div>vocabulary: <strong>{$scheme|htmlentities}</strong></div>
      {else}
        <div>query: {$query|htmlentities}</div>
      {/if}
      <div id="terms-content">
        {include 'marc-facets.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}