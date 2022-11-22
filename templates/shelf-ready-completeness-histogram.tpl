<link rel="stylesheet" href="styles/histogram.css">
<h3>histogram</h3>

<svg class="shelf-ready-completeness-histogram-chart-total" width="960" height="300"></svg>
<ul>
  <li>y axis: number of records</li>
  <li>x axis: total score of a record</li>
</ul>

<p>Each record get a score based on a number of criteria. Each criteria results in a
  positive score. The final (rounded) score is the summary of these criteria scores.</p>

<table id="criteria-list">
  <thead>
    <tr>
      <th></th>
      <th>Record Element</th>
      <th>MARC field/position/subfield</th>
      <th>Score</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$fields key=index item=field}
    <tr>
      <td class="id"><a href="#shelf-ready-component-{$index + 1}">{$index + 1}.</a></td>
      <td>{$field->label}</td>
      <td width="60%">
        {foreach from=$field->paths key=index item=path name=paths}
          <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
        {/foreach}
      </td>
      <td align="right">{$field->score}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<h3>components</h3>

<p>The histograms of the individual components:</p>

<table>
{foreach from=$fields key=index item=field}
  {if $index % 3 == 0}
      <tr>
  {/if}
    <td>
      <svg class="shelf-ready-completeness-histogram-chart-{$field->name}" width="320" height="200"></svg>
      <p id="shelf-ready-component-{$index+1}">
          {$index+1}. {$field->label}<br/>
        score: 0&mdash;{$field->score}
      </p>
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
var count = {$count};
var units = 'score';
var fields = {json_encode($fields)};
{literal}

var tooltip = d3.select("body")
  .append("div")
  .style("opacity", 0)
  .attr("class", "tooltip")
  .attr("id", "tooltip")

showHistogram('total');
for (var i in fields) {
  var field = fields[i];
  showHistogram(field.name);
}

function showHistogram(field) {
  var histogramDataUrl = '?tab=histogram&file=shelf-ready-completeness-histogram-' + field;
  var histogramSvgClass = "shelf-ready-completeness-histogram-chart-" + field;
  displayHistogram(histogramDataUrl, histogramSvgClass);
}

{/literal}
</script>