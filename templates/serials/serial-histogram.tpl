<link rel="stylesheet" href="styles/histogram.css">
<h3>{_('Histogram')}</h3>

<svg class="serial-histogram-chart-total" width="960" height="300"></svg>
<ul>
  <li>y: number of records</li>
  <li>x: number of authority names in one record</li>
</ul>

Each records having ... get a score based on a number of criteria.
Each criteria results in a positive or negative score. The final score is
these criteria scores.

<table>
  <thead>
    <tr>
      <th>criteria</th>
      <th>score</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>date1 (008/07-11) is unknown ('uuuu')</td>
      <td>-3</td>
    </tr>
    <tr>
      <td>place of publication (008/15) is unknown (~ 'xx.+')</td>
      <td>-1</td>
    </tr>
    <tr>
      <td>publication language (008/35) is unknown (xxx)</td>
      <td>-1</td>
    </tr>
    <tr>
      <td>has authentication code (042$a)</td>
      <td>7</td>
    </tr>
    <tr>
      <td>encoding level (LDR/17) is Full level (‘ ‘) or Full level, material not examined (1) or Full level input by OCLC participants (I)</td>
      <td>7</td>
    </tr>
    <tr>
      <td>encoding level (LDR/17) is Added from a batch process (M), L, or Minimal level input by OCLC participants (K), or Minimal level (7)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has 006 field</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has publisher (260)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has production, publication, distribution (264)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has publication frequency (310)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has content type (336)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has dates of publication (362)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has source of description (588)</td>
      <td>1</td>
    </tr>
    <tr>
      <td>has no subject headings</td>
      <td>-5</td>
    </tr>
    <tr>
      <td>for each subject headings</td>
      <td>1</td>
    </tr>
    <tr>
      <td>authentication code (042$a) = “ppc”</td>
      <td>100</td>
    </tr>
    <tr>
      <td>date1 begins with '0'</td>
      <td>-100</td>
    </tr>
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
    <p id="serial-histogram-{$index+1}">{$index+1}. {$field->name}</p>
    <svg class="serial-histogram-chart-{$field->transformed}" width="320" height="200"></svg>
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
  showHistogram(field.transformed);
}

function showHistogram(field) {
  var histogramDataUrl = '?tab=histogram&file=serial-score-histogram-' + field;
  var histogramSvgClass = "serial-histogram-chart-" + field;
  displayHistogram(histogramDataUrl, histogramSvgClass);
}

{/literal}
</script>
