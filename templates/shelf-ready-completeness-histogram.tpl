<h3>histogram</h3>

<style>
  .bar {
    fill: steelblue;
  }

  .axis text {
    font: 10px sans-serif;
  }

  .axis path,
  .axis line {
    fill: none;
    stroke: #000;
    shape-rendering: crispEdges;
  }

  .x.axis path {
    display: none;
  }
</style>

<svg class="shelf-ready-completeness-histogram-chart-total" width="960" height="300"></svg>
<ul>
  <li>y axis: number of records</li>
  <li>x axis: total score of a record</li>
</ul>

<p>Each record get a score based on a number of criteria. Each criteria results in a
  positive score. The final (rounded) score is the summary of these criteria scores.</p>

<table>
  <thead>
    <tr>
      <th>Record Element</th>
      <th>MARC field/position/subfield</th>
      <th>Score</th>
    </tr>
  </thead>
  <tbody>
  {foreach $fields as $index => $field}
    <tr>
      <td><a href="#shelf-ready-component-{$index + 1}">{$index + 1}.</a> {$field->label}</td>
      <td>{$field->marcpath}</td>
      <td>{$field->score}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<h3>components</h3>

<p>The histograms of the individual components:</p>

<table>
{foreach $fields as $index => $field}
  {if $index % 3 == 0}
      <tr>
  {/if}
    <td>
      <p id="shelf-ready-component-{$index+1}">
        {$index+1}. {$field->label}<br/>
        score: 0&mdash;{$field->score}
      </p>
      <svg class="shelf-ready-completeness-histogram-chart-{$field->name}" width="320" height="200"></svg>
    </td>
  {if $index % 3 == 2 || $index == count($fields) - 1}
    </tr>
  {/if}
{/foreach}
</table>

<script src="js/histogram.js" type="text/javascript"></script>
<script>
// $()
var db = '{$db}';
var fields = {json_encode($fields)};
{literal}

var tooltipSerial = d3.select("body")
  .append("div")
  .style("opacity", 0)
  .attr("class", "tooltip")
  .attr("id", "tooltip-serial")

showHistogram('total');
for (var i in fields) {
  var field = fields[i];
  showHistogram(field.name);
}

function showHistogram(field) {
  var histogramDataUrl = 'read-histogram.php?db='+ db + '&file=shelf-ready-completeness-histogram-' + field;
  var histogramSvgClass = "shelf-ready-completeness-histogram-chart-" + field;
  displayHistogram(histogramDataUrl, histogramSvgClass);
}

{/literal}
</script>