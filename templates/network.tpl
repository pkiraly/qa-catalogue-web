{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="network" role="tabpanel" aria-labelledby="network-tab">
      <h2>Network analysis</h2>
      <div id="network-content">
        {include 'network-content.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}