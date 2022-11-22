{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>Terms</h2>
      {if $scheme == ''}
        <form id="facetselection">
          <input type="hidden" name="tab" value="terms" />
          <input type="hidden" name="query" value="{$query}" />
          <p>
            field: <input list="facet" name="facet" id="facetInput" style="width: 800px;" value="{if isset($facet) && !empty($facet)}{$facet}{else}- select a field! -{/if}">
            <datalist id="facet">
              <option value="">-- select --</option>
              {foreach from=$solrFields item=field}
                <option value="{$field}"{if $field == $facet} selected="selected"{/if}>{$field}</option>
              {/foreach}
            </datalist>
          </p>

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