{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
      <h2>Set facets</h2>
      {if $saved}
        <div style="border-color: #f0c040; margin: 20px; padding: 20px; background-color: #eeeeee">
          {if $success}
            <i class="fa fa-info" aria-hidden="true" style="color: #37ba00"></i> Facets have been saved successfully.
          {else}
            <i class="fa fa-info" aria-hidden="true" style="color: #9B410E"></i> Facets has not been saved. Check the log.
          {/if}
        </div>
      {/if}
      <div id="set-facet-list">
        <form id="facetselection" method="post">
          <input type="hidden" name="tab" value="settings" />
          {foreach $facets as $facet}
            <input type="checkbox" value="{$facet->name}" name="facet[]" id="{$facet->name}"{if $facet->checked} checked="checked"{/if}>
            <label for="{$facet->name}">{$facet->name}</label><br/>
          {/foreach}

          <div style="margin: 20px; padding: 20px;">
            <input type="submit" value="save" id="save-facet-change" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
