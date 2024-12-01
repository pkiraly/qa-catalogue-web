{include 'common/html-head.tpl'}
<link rel="stylesheet" href="styles/histogram.css">
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="data-element-timeline" role="tabpanel" aria-labelledby="data-element-timeline-tab">
      <h2>{_('Data element timeline')}</h2>
      <p class="metric-definition">
          {_('data_element_timeline_definition')}
      </p>

      <form id="facetselection">
        <input type="hidden" name="tab" value="data-element-timeline" />
        <input type="hidden" name="lang" value="{$lang}" />
        {include 'common/field-selector.tpl' id="field" name="facetName" idValue=$dataElement labelValue=$label}
        <button type="submit" class="btn">
          <i class="fa fa-search" aria-hidden="true"></i> {_('select')}
        </button>
      </form>

      <svg class="histogram-chart" width="960" height="300"></svg>

      <script src="js/histogram.js" type="text/javascript"></script>
      <script>
        const db = '{$id}';
        const count = {$count};
        const dataELement = '{$dataElement}';
        {literal}
        const units = 'year';
        const histogramDataUrl = '?tab=data-element-timeline&action=download&field=' + dataELement;
        const histogramSvgClass = 'histogram-chart';

        const tooltip = d3.select("body")
          .append("div")
          .style("opacity", 0)
          .attr("class", "tooltip")
          .attr("id", "tooltip")
        displayHistogram(histogramDataUrl, histogramSvgClass);
        {/literal}
      </script>
    </div>
  </div>
  {include 'common/parameters.tpl'}
</div>
{include 'common/html-footer.tpl'}
