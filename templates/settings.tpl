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
      <div id="set-facet-list">
        <form id="facetselection" method="post">
          <input type="hidden" name="tab" value="settings" />
          {foreach from=$categories key=category item=fields}
            <p><strong>{$category}</strong> ({_t('%d fields', count($fields))})</p>
            <select name="facet[]" multiple="multiple" size="15">
              <option value="">-- {_('select')} --</option>
              {foreach from=$fields item=field}
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
