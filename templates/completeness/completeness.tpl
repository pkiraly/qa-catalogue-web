{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="completeness" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>{_('Completeness')}</h2>

      {if $controller->groupped}
        <div id="group-selector">
          <form>
            <input type="hidden" name="tab" value="{$tab}">
            <input type="hidden" name="type" value="{$selectedType}">
            <select name="groupId" onchange="this.form.submit()">
              {foreach from=$groups item=group}
                <option value="{$group->id}" {if ($group->id == $groupId)}selected="selected"{/if}>{$group->group} ({$group->count})</option>
              {/foreach}
            </select>
          </form>
        </div>
      {/if}

      <div>
        {_('by document types')}:
        {foreach from=$types item=type name=types}
          {if !$smarty.foreach.types.first}·{/if}
          {if $type == $selectedType}
            <strong>{$type}</strong>
          {else}
            <a href="?tab=completeness&type={urlencode($type)}">{$type}</a>
          {/if}
        {/foreach}
      </div>
      <div>
        {_('number of records')}: <strong>{$max|number_format}</strong>
      </div>

      <h3>field groups</h3>
      <div id="completeness-group-table">
        {include 'completeness/completeness-packages.tpl'}
      </div>

      <h3>fields</h3>
      <div id="completeness-field-table">
        {include 'completeness/completeness-fields.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
