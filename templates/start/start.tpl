{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="start" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>{_('Start')}</h2>

      {include 'common/group-selector.tpl'}

    </div>

    <div>
      <canvas id="issuesGraph"></canvas>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script language="JavaScript" type="text/javascript">
        {include file="js/start.js.tpl"}
      </script>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
