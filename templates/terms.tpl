{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>Terms</h2>

      {include 'common/group-selector.tpl'}

      {if $scheme == ''}
        <form id="facetselection">
          <input type="hidden" name="tab" value="terms" />
          <input type="hidden" name="query" value="{$query}" />

          <p>
            <input name="facet" id="facet" onchange="this.form.submit()" type="hidden" value="{$facet}">
            <label for="facetName">{_('Field')}:</label>
            <input id="facetName" value="{$label}" size="80">
          </p>
          <script>
            $(function() {
              $("#facetName").autocomplete({
                source: '?tab=terms&action=fields',
                select: function(event, ui) {
                  $("#facetName").val(ui.item.label);
                  $("#facet").val(ui.item.value);
                  return false;
                },
                focus: function(event, ui) {
                  $("#facetName").val(ui.item.label);
                  $("#facet").val(ui.item.value);
                  return false;
                },
              });
            });
          </script>

          <p>
            filter term list: <input type="text" name="termFilter" value="{$termFilter}" /><br/>
          </p>

          <button type="submit" class="btn">
            <i class="fa fa-search" aria-hidden="true"></i> Term list
          </button>
        </form>
      {/if}

      {if $scheme != ''}
        <div>vocabulary: <strong>{$scheme|htmlentities}</strong></div>
      {elseif $facet != ''}
        <div>query: {$query|htmlentities}</div>
          {if !empty($filters)}
            <div>filters:
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
        <a href="{$controller->createDownloadLink()}"><i class="fa-solid fa-file-arrow-down"></i></a>
        <a href="{$controller->createDownloadLink()}">download this list</a>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}