{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="data" role="tabpanel" aria-labelledby="data-tab">
      <h2>{_('Search')}</h2>
      <p class="metric-definition">
        {_('data_definition')}
      </p>
      <div class="container" id="content">
        <div class="row">
          <div class="col-3 search-block"></div>
          <div class="col search-block">
            {if $showAdvancedSearchForm}
              <ul class="nav nav-tabs" id="searchforms">
                <li class="nav-item">
                  <a class="nav-link {if $searchform == 'simple'}active{/if}" data-toggle="tab" role="tab" aria-selected="true"
                     id="simple-search-tab" href="#simple-search" aria-controls="simple-search-tab">simple search</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {if $searchform == 'advanced'}active{/if}" data-toggle="tab" role="tab" aria-selected="true"
                     id="advanced-search-tab" href="#advanced-search" aria-controls="advanced-search-tab">advanced search</a>
                </li>
              </ul>
              <div class="tab-content" id="search-tabs">
                <div class="tab-pane {if $searchform == 'simple'}active{/if}" id="simple-search" role="tabpanel" aria-labelledby="data-tab">
                  {include 'data/simple-search.tpl'}
                </div>
                <div class="tab-pane {if $searchform == 'advanced'}active{/if} record-tab" id="advanced-search" role="tabpanel" aria-labelledby="data-tab">
                  {include 'data/advanced-search.tpl'}
                </div>
              </div>
            {else}
              {include 'data/simple-search.tpl'}
            {/if}
          </div>
        </div>
        </div>
        <div class="row">
        </div>
        <div class="row">
          <div id="left" class="col-3">
            <div id="filters" class="filter-block">
              {if count($filters) > 0}
                <h3>{_('Filters')}</h3>
                <div id="filter-list">
                  <ul>
                    {foreach from=$filters item=filter}
                      <li>
                        <a href="?{$filter->removeLink->url}" title="{_('remove it from the query')}"><i class="fa fa-minus" aria-hidden="true"></i></a>
                        {$filter->marcCode}: {$filter->removeLink->text}
                        <a href="?{$filter->changeQuery->url}" title="{_('make it the main query')}"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        <a href="?{$filter->termsLink}" title="{_('check other terms of this field')}"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
                      </li>
                    {/foreach}
                  </ul>
                </div>
              {/if}
            </div>
            <div id="facets" class="facet-block">
              <h3><a href="?tab=settings&lang={$lang}">{_('Facets')}</a></h3>
              <div id="facet-list">
                {include 'marc-facets.tpl'}
              </div>
            </div>
          </div>
          <div id="main" class="col">
            <div class="row">
              <div class="col-8">
                {_t('Found %s records', $numFound|number_format)}
              </div>
              <div class="col-4 text-right" id="message">
                <a href="{$controller->getDownloadLink()}" title="{_('download identifiers')}"><i class="fa fa-download" aria-hidden="true"></i></a>
              </div>
            </div>

            <div class="row" id="navigation">
              <div class="col-6" id="prev-next">
                {include 'data/data-bold-links.tpl' items=$prevNextLinks}
              </div>
              <div class="col-6 text-right" id="per-page">
                <span class="label">{_('Items per page')}:</span>
                <span id="items-per-page">
                  {include 'data/data-bold-links.tpl' items=$itemsPerPage}
                </span>
              </div>
            </div>

            <div id="records">
              {if $schemaType == 'PICA'}
                {include 'data/pica-records-based-on-json.tpl'}
              {else}
                {include 'data/marc-records-based-on-json.tpl'}
              {/if}
            </div>

            <div class="row" id="navigation-footer">
              <div class="col-8" id="prev-next-footer">
                {include 'data/data-bold-links.tpl' items=$prevNextLinks}
              </div>
              <div class="col-4 text-right">
                <a href="{$controller->getDownloadLink()}" title="{_('download identifiers')}"><i class="fa fa-download" aria-hidden="true"></i></a>
              </div>
            </div>
            <div id="solr-url">{htmlentities($solrUrl)}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{literal}
<script>
function setFacetNavigationClickBehaviour() {
  $('a.ajax-facet-navigation').click(function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    var field = $(this).attr('data-field');
    $.ajax(url)
      .done(function (result) {
        $('#' + field).html(result);
        setFacetNavigationClickBehaviour();
      });
    });
}

function activateTab(type, id) {
  issueTabid = type + '-issue-' + id;
  $('#details-tab-' + id + ' .tab-pane').each(function() {
    if ($(this).attr('id') == issueTabid) {
      $(this).addClass('active');
    } else {
      $(this).removeClass('active');
    }
  });
}

$(document).ready(function() {
  $('.record h2 a.record-details').click(function (event) {
    event.preventDefault();
    var detailsId = $(this).attr('data');
    $('#' + detailsId).toggle();
  });

  $('a[aria-controls="marc-issue-tab"]').click(function (event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var url = $(this).attr('href');
    activateTab('marc', id);
    $.ajax(url)
      .done(function(result) {
        $('#marc-issue-' + id).html(result);
      });
  });

  $('a[aria-controls="pica-issue-tab"]').click(function (event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var url = $(this).attr('href');
    activateTab('pica', id);
    $.ajax(url)
     .done(function(result) {
       $('#pica-issue-' + id).html(result);
    });
  });

  setFacetNavigationClickBehaviour();
});
</script>
{/literal}
{include 'common/html-footer.tpl'}
