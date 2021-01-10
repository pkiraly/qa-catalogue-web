{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="completeness" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>Completeness of MARC21 field groups</h2>
      <div id="completeness-group-table">
        {include 'completeness-packages.tpl'}
      </div>

      <h2>Completeness of MARC21 fields</h2>
      <div>
        by document types:
        {foreach $types as $type name=types}
          {if $type == $selectedType}
            <strong>{$type}</strong>
          {else}
            <a href="?tab=completeness&type={urlencode($type)}">{$type}</a>
          {/if}
          {if !$smarty.foreach.types.last}·{/if}
        {/foreach}
      </div>
      <div>
        number of records for the type: <strong>{$max|number_format}</strong>
      </div>

      <div id="completeness-field-table">
        {include 'completeness-fields.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
