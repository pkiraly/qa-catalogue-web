{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="start" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>{_('Start')}</h2>

      {include 'common/group-selector.tpl'}

    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
