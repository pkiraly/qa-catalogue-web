

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

      {include 'start/grid-item.tpl' id='authoritiesGraph' title='Subject analysis' ref="?tab=classifications{$generalParams}"}

      <div class='grid-item'>
        <div class='grid-item-title'>
          <a class='grid-item-title-text' href='?tab=completeness{$generalParams}'>Completeness</a>
          <a class='btn' id="completenessBack" style='float:right'>❮</a>
        </div>
        <div class='grid-item-content'>
          <div class="graph" id="completenessGraph"></div>
        </div>
      </div>

      {include 'start/grid-item.tpl' id='authoritiesNameGraph' title='Authority name analysis' ref="?tab=authorities{$generalParams}"}
      {include 'start/grid-item.tpl' id='issuesGraph' title='Issues' ref="?tab=issues{$generalParams}"}

      <div class='grid-item'>
        <div class='grid-item-title'>
          <a class='grid-item-title-text' href='?tab=shelf-ready-completeness{$generalParams}'>Booth shelf ready</a>
        </div>
        <div class='grid-item-content'>
          <div class="graph" id="boothShelfReady"></div>
        </div>
      </div>      

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap/dist/chartjs-chart-treemap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-charts-community@8.1.0/dist/ag-charts-community.min.js"></script>
    <script language="JavaScript" type="text/javascript">
      {include file="js/start.js.tpl"}
    </script>

  </div>
</div>
{include 'common/html-footer.tpl'}