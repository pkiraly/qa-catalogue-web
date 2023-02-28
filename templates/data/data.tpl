{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="data" role="tabpanel" aria-labelledby="data-tab">
      <div class="container" id="content">
        <div class="row">
          <div class="col-3 search-block">
            <h3>Search</h3>
          </div>
          <div class="col search-block">
            <form id="search">
              <input type="hidden" name="tab" value="data">
              <input type="text" name="query" id="query" value="{htmlentities($query)}" size="65">
              <button type="submit" class="btn">
                <i class="fa fa-search" aria-hidden="true"></i> search
              </button>
            </form>
          </div>
        </div>
        <div class="row">
          <div id="left" class="col-3">
            <div id="filters" class="filter-block">
              {if count($filters) > 0}
                <h3>Filters</h3>
                <div id="filter-list">
                  <ul>
                    {foreach from=$filters item=filter}
                      <li>
                        <a href="?{$filter->removeLink->url}" title="remove it from the query"><i class="fa fa-minus" aria-hidden="true"></i></a>
                        {$filter->marcCode}: {$filter->removeLink->text}
                        <a href="?{$filter->changeQuery->url}" title="make it the main query"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        <a href="?{$filter->termsLink}" title="check other terms of this field"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
                      </li>
                    {/foreach}
                  </ul>
                </div>
              {/if}
            </div>
            <div id="facets" class="facet-block">
              <h3>Facets</h3>
              <div id="facet-list">
                {include 'marc-facets.tpl'}
              </div>
            </div>
          </div>
          <div id="main" class="col">
            <div class="row">
              <div class="col-8">
                Found <span id="numFound">{$numFound|number_format}</span> records
              </div>
              <div class="col-4" id="message"></div>
            </div>

            <div class="row" id="navigation">
              <div class="col-8" id="prev-next">
                {include 'data/data-bold-links.tpl' items=$prevNextLinks}
              </div>
              <div class="col-4" id="per-page">
                <span class="label">Items per page:</span>
                <span id="items-per-page">
                  {include 'data/data-bold-links.tpl' items=$itemsPerPage}
                </span>
              </div>
            </div>

            <div id="records">
              {if $schemaType == 'PICA'}
                {include 'data/pica-records-based-on-json.tpl'}
              {else}
                {include 'data/marc-records-based-on-marcjson.tpl'}
              {/if}
            </div>

            <div class="row" id="navigation-footer">
              <div class="col-8" id="prev-next-footer">
                {include 'data/data-bold-links.tpl' items=$prevNextLinks}
              </div>
              <div class="col-4"></div>
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

function activateTab(id) {
  issueTabid = 'marc-issue-' + id;
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
    activateTab(id);
    $.ajax(url)
      .done(function(result) {
        $('#marc-issue-' + id).html(result);
      });
    });

  setFacetNavigationClickBehaviour();
});

</script>
{/literal}
{include 'common/html-footer.tpl'}
