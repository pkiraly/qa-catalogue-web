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
      <th></th>
      <th>criteria</th>
      <th>score</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="id"><a href="#serial-histogram-1">1.</a></td>
      <td>date1 (008/07-11) is unknown ('uuuu')</td>
      <td>-3</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-2">2.</a></td>
      <td>place of publication (008/15) is unknown (~ 'xx.+')</td>
      <td>-1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-3">3.</a></td>
      <td>publication language (008/35) is unknown (xxx)</td>
      <td>-1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-4">4.</a></td>
      <td>has authentication code (042$a)</td>
      <td>7</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-5">5.</a></td>
      <td>encoding level (LDR/17) is Full level (‘ ‘) or Full level, material not examined (1) or Full level input by OCLC participants (I)</td>
      <td>7</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-6">6.</a></td>
      <td>encoding level (LDR/17) is Added from a batch process (M), L, or Minimal level input by OCLC participants (K), or Minimal level (7)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-7">7.</a></td>
      <td>has 006 field</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-8">8.</a></td>
      <td>has publisher (260)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-9">9.</a></td>
      <td>has production, publication, distribution (264)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-10">10.</a></td>
      <td>has publication frequency (310)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-11">11.</a></td>
      <td>has content type (336)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-12">12.</a></td>
      <td>has dates of publication (362)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-13">13.</a></td>
      <td>has source of description (588)</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-14">14.</a></td>
      <td>has no subject headings</td>
      <td>-5</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-15">15.</a></td>
      <td>for each subject headings</td>
      <td>1</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-16">16.</a></td>
      <td>authentication code (042$a) = “ppc”</td>
      <td>100</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-17">17.</a></td>
      <td>date1 begins with '0'</td>
      <td>-100</td>
    </tr>
    <tr>
      <td class="id"><a href="#serial-histogram-18">18.</a></td>
      <td>Encoding level is abbreviated</td>
      <td>-100</td>
    </tr>
  </tbody>
</table>

<h3>components</h3>

<p>The histograms of the individual components:</p>

<table>
{foreach from=$fields key=index item=field}
  {if $index % 3 == 1}
    <tr>
  {/if}
  <td>
    <p id="serial-histogram-{$index}"><strong>{$index}.</strong> {$field->name}</p>
    <svg class="serial-histogram-chart-{$field->transformed}" width="320" height="200"></svg>
  </td>
  {if $index % 3 == 0 || ($index == count($fields))}
    </tr>
  {/if}
{/foreach}
</table>

<script src="js/histogram.js" type="text/javascript"></script>
<script>
// $()
var db = '{$id}';
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
