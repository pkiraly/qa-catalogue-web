{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
      <h2>{_('Set facets')}</h2>

      <p class="metric-definition">
        {_('setings_definition')}
      </p>

      {if $saved}
        <div style="border-color: #f0c040; margin: 20px; padding: 20px; background-color: #eeeeee">
          {if $success}
            <i class="fa fa-info" aria-hidden="true" style="color: #37ba00"></i> {_('Facets have been saved successfully.')}
          {else}
            <i class="fa fa-info" aria-hidden="true" style="color: #9B410E"></i> {_('Facets has not been saved. Check the log.')}
          {/if}
        </div>
      {/if}

      {if !empty($selectedFacets)}
        <h3>{_('Saved facets')}:</h3>
        <ul>
          {foreach from=$selectedFacets item=facet}
            <li>
              <form method="post">
                {$facet['label']}
                <input type="hidden" name="tab" value="settings" />
                <input type="hidden" name="lang" value="{$lang}" />
                <input type="hidden" name="action" value="remove" />
                <input type="hidden" name="facet" value="{$facet['id']}" />
                <input type="submit" value="remove" id="save-facet-change" />
              </form>
            </li>
          {/foreach}
        </ul>
      {/if}

      <h3>{_('Add facet')}</h3>
      <form id="facetselection" method="post">
        <input type="hidden" name="tab" value="settings" />
        <input type="hidden" name="lang" value="{$lang}" />
        <input type="hidden" name="action" value="add" />
        {include 'common/field-selector.tpl' id="facet" name="facetName"}
        <div style="margin: 20px; padding: 20px;">
          <input type="submit" value="save" id="save-facet-change" />
        </div>
      </form>

    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
