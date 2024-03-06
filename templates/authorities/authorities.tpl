{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="authorities" role="tabpanel" aria-labelledby="authorities-tab">
      <h2>{_('Authority name analysis')}</h2>

      <p class="metric-definition">
        {_('authorities_definition')}
      </p>

      <div id="authorities-content">
        {include 'authorities/authorities-by-records.tpl'}
        {include 'authorities/authorities-histogram.tpl'}
        {include 'authorities/authorities-by-field.tpl'}
      </div>
    </div>
  </div>
  {include 'common/parameters.tpl'}
</div>
{include 'common/html-footer.tpl'}