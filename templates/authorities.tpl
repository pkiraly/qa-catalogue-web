{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="authorities" role="tabpanel" aria-labelledby="authorities-tab">
      <h2>Authority analysis</h2>
      <div id="authorities-content">
        {include 'authorities-by-records.tpl'}
        {include 'authorities-histogram.tpl'}
        {include 'authorities-by-field.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}