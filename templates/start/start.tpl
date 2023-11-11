

{include 'common/html-head.tpl'}

<link rel="stylesheet" type="text/css" href="styles/start.css">

<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="start" role="tabpanel" aria-labelledby="start-tab">
      <h2>{_('Start')}</h2>

    </div>

    <div class='grid-container'>

      {include 'start/grid-item.tpl' id='authoritiesGraph' title={_('Subject analysis')} ref="?tab=classifications{$generalParams}"}

      <div class='grid-item'>
        <div class='grid-item-title'>
          <a class='grid-item-title-text' href='?tab=completeness{$generalParams}'>{_('Completeness')}</a>
          <a class='btn' id="completenessBack" style='float:right'>❮</a>
	        <div class='trunc-container' style='float:right;max-width:calc(100% - 128px - 34px - 5px)'>
            <a class='trunc-label' id="location" style='font-size:10pt;padding-top:.6rem'></a>
          </div>
        </div>
        <div class='grid-item-content'>
          <canvas class="graph" id="completenessGraph"></canvas>
        </div>
      </div>

      {include 'start/grid-item.tpl' id='issuesGraph' title={_('Issues')} ref="?tab=issues{$generalParams}"}
      {include 'start/grid-item.tpl' id='authoritiesNameGraph' title={_('Authority name analysis')} ref="?tab=authorities{$generalParams}"}

      <div class='grid-item'>
        <div class='grid-item-title'>
          <a class='grid-item-title-text' href='?tab=shelf-ready-completeness{$generalParams}'>{_('Shelf ready complteness')}</a>
        </div>
        <div class='grid-item-content'>
          <div class="spec-graph" id="boothShelfReady"></div>
        </div>
      </div>      

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-charts-community@8.1.0/dist/ag-charts-community.min.js"></script>
    <script language="JavaScript" type="text/javascript">
      {include file="js/start.js.tpl"}
    </script>

  </div>
</div>
{include 'common/html-footer.tpl'}
