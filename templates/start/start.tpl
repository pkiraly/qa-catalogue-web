

{include 'common/html-head.tpl'}

<link rel="stylesheet" type="text/css" href="styles/start.css">

<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="start" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>{_('Start')}</h2>

    </div>

    <div class='grid-container'>

      {include 'start/grid-item.tpl' id='issuesGraph' title='Issues' ref="?tab=issues{$generalParams}"}

      {include 'start/grid-item.tpl' id='completenessGraph' title='Completeness' ref="?tab=completeness{$generalParams}"}

      {include 'start/grid-item.tpl' id='totalCompletenessGraph' title='Blabla' ref="?tab=completeness{$generalParams}"}

      <div class='grid-item'/>
        2
      </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap/dist/chartjs-chart-treemap.min.js"></script>
    <script language="JavaScript" type="text/javascript">
      {include file="js/start.js.tpl"}
    </script>

  </div>
</div>
{include 'common/html-footer.tpl'}
