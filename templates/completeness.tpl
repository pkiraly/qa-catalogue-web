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
      <div id="completeness-field-table">
        {include 'completeness-fields.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
