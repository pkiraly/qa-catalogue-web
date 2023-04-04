{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>{_('Terms')}</h2>

      <p class="metric-definition">
        {_('terms_definition')}
      </p>

      {if $scheme == ''}
        <form id="facetselection">
          <input type="hidden" name="tab" value="terms" />
          <input type="hidden" name="lang" value="{$lang}" />
          <input type="hidden" name="query" value="{$query}" />

          {if $groupped}
            {include 'common/library-selector.tpl'}
          {/if}
          {include 'common/field-selector.tpl' id="facet" name="facetName" idValue=$facet labelValue=$label}

          <p>{_('filter term list')}: <input type="text" name="termFilter" value="{$termFilter}" /></p>

          <button type="submit" class="btn">
            <i class="fa fa-search" aria-hidden="true"></i> {_('Term list')}
          </button>
        </form>
      {/if}

      {if $scheme != ''}
        <div>{_('vocabulary')}: <strong>{$scheme|htmlentities}</strong></div>
      {elseif $facet != ''}
        <div>{_('query')}: {$query|htmlentities}</div>
          {if !empty($filters)}
            <div>{_('filters')}:
              {foreach from=$filters item="filter" name="filters"}
                {$filter|urldecode}{if !$smarty.foreach.filters.last}, {/if}
              {/foreach}
            </div>
          {/if}
      {/if}

      <div id="terms-content">
        {include 'marc-facets.tpl'}
      </div>

      <div>
        <a href="{$controller->createDownloadLink()}"><i class="fa fa-download"></i></a>
        <a href="{$controller->createDownloadLink()}">{_('download this list')}</a>
      </div>
    </div>
  </div>
</div>
<script>
$(function() {
  var url = "{$controller->getCountUrl()}";
  $.ajax(url)
    .done(function (result) {
      $('#terms-count').html(result);
      $('span.terms-count').show();
    });
});
</script>
{include 'common/html-footer.tpl'}
