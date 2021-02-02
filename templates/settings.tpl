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
          {foreach $categories as $category => $fields}
            <p><strong>{$category}</strong> ({count($fields)} fields)</p>
            <select name="facet[]" multiple="multiple">
              <option value="">-- select --</option>
              {foreach $fields as $field}
                <option value="{$field->name}"{if $field->checked} selected="selected"{/if}>{$field->name}</option>
              {/foreach}
            </select>
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
