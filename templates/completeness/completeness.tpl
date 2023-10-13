{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="completeness" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>{_('Completeness')}</h2>

      <p class="metric-definition">
        {_('completeness_definition')}
      </p>

      {include 'common/group-selector.tpl'}

      <div id="document-type-selector">
        {_('by document types')}:
        {foreach from=$types item=type name=types}
          {if !$smarty.foreach.types.first}·{/if}
          {if $type == $selectedType}
            <strong>{$type}</strong>
          {else}
            <a href="?tab=completeness{$controller->getTabSpecificParameters('type', $type)}">{$type}</a>
          {/if}
        {/foreach}
      </div>
      <div>
        {_('number of records')}: <strong>{$max|number_format}</strong>
      </div>


      <h3>{_('Field groups')}</h3>
      <div id="completeness-group-table">
        {include 'completeness/completeness-packages.tpl'}
      </div>

      <h3>{_('Fields')}</h3>
      <div id="completeness-field-table">
        {* include 'completeness/completeness-fields.tpl' *}
        {include 'completeness/completeness-fields2.tpl'}
      </div>
    </div>
  </div>
  {include 'common/parameters.tpl'}
</div>
{include 'common/html-footer.tpl'}
