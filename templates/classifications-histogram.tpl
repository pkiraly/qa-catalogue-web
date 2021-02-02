<link rel="stylesheet" href="styles/histogram.css">
<h3>histogram</h3>

<svg class="histogram-chart" width="960" height="300"></svg>
<ul>
  <li>y: number of records</li>
  <li>x: number of subjects in one record</li>
</ul>
<script src="js/histogram.js" type="text/javascript"></script>
<script>
var db = '{$db}';
var count = {$count};
{literal}
var units = 'classifications';
var histogramDataUrl = '?tab=histogram&file=classifications-histogram';
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
  <em>example records (one record for each subject count):</em>
  {foreach $frequencyExamples as $count => $id name=examples}
    <a href="?tab=data&query=id:{urlencode(sprintf('"%s"', $id))}">{$count}</a>{if !$smarty.foreach.examples.last},{/if}
  {/foreach}
</p>
