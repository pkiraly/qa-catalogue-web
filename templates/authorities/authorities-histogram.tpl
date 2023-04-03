<link rel="stylesheet" href="styles/histogram.css">
<h3>{_('Histogram')}</h3>

<svg class="histogram-chart" width="960" height="300"></svg>
<ul>
  <li>
    {if $catalogue->getSchemaType() == 'MARC21'}
      {_('x: number of authority names per record')}
    {elseif $catalogue->getSchemaType() == 'PICA'}
      {_('x: number of authority name field per record')}
    {/if}
  </li>
  <li>{_('y: number of records')}</li>
</ul>
<script src="js/histogram.js" type="text/javascript"></script>
<script>
var db = '{$db}';
var count = {$count};
{literal}
var units = 'authorities';
var histogramDataUrl = '?tab=histogram&file=authorities-histogram';
var histogramSvgClass = 'histogram-chart';

var tooltip = d3.select("body")
    .append("div")
    .style("opacity", 0)
    .attr("class", "tooltip")
    .attr("id", "tooltip")
displayHistogram(histogramDataUrl, histogramSvgClass);
{/literal}
</script>

<p>
  <em>example records (one record for each authority count):</em>
  {foreach from=$frequencyExamples key=count item=id name=examples}
    <a href="{$controller->queryLink($id)}">{$count}</a>{if !$smarty.foreach.examples.last},{/if}
  {/foreach}
</p>
