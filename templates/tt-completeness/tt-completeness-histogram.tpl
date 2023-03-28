<link rel="stylesheet" href="styles/histogram.css">
<h3>{_('Histogram')}</h3>

<svg class="tt-completeness-histogram-chart-total" width="960" height="300"></svg>
<ul>
  <li>y axis: number of records</li>
  <li>x axis: total score of a record</li>
</ul>

<p>
Each record get a score based on a number of criteria.
Each criteria results in a positive score. The final score is
the summary of these criteria scores.
</p

<table id="criteria-list">
  <thead>
    <tr>
      <th></th>
      <th>Record Element</th>
      <th>MARC field/position/subfield</th>
      <th>How counted</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="id"><a href="#tt-component-1">1.</a></td>
      <td>ISBN</td>
      <td width="50%">
        {if isset($fields[1]->paths)}
          {foreach from=$fields[1]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          020
        {/if}
      </td>
      <td>1 point for each occurrence of field</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-2">2.</a></td>
      <td>Authors</td>
      <td width="50%">
        {if isset($fields[2]->paths)}
          {foreach from=$fields[2]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          100, 110, 111
        {/if}
      </td>
      <td>1 point for each occurrence of field(s)</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-3">3.</a></td>
      <td>Alternative Titles</td>
      <td width="50%">
        {if isset($fields[3]->paths)}
          {foreach from=$fields[3]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          246
        {/if}
      </td>
      <td>1 point for each occurrence of field</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-4">4.</a></td>
      <td>Edition</td>
      <td width="50%">
        {if isset($fields[4]->paths)}
          {foreach from=$fields[4]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          250
        {/if}
      </td>
      <td>1 point for each occurrence of field</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-5">5.</a></td>
      <td>Contributors</td>
      <td width="50%">
        {if isset($fields[5]->paths)}
          {foreach from=$fields[5]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          700, 710, 711, 720
        {/if}
      </td>
      <td>1 point for each occurrence of field(s)</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-6">6.</a></td>
      <td>Series</td>
      <td width="50%">
        {if isset($fields[6]->paths)}
          {foreach from=$fields[6]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          440, 490, 800, 810, 830
        {/if}
      </td>
      <td>1 point for each occurrence of field(s)</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-7">7.</a></td>
      <td>Table of Contents and Abstract</td>
      <td width="50%">
        {if isset($fields[7]->paths)}
          {foreach from=$fields[7]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          505, 520
        {/if}
      </td>
      <td>2 points if both fields exist; 1 point if either field exists</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-8">8.</a></td>
      <td>Date (MARC 008)</td>
      <td width="50%">
        {if isset($fields[8]->paths)}
          {foreach from=$fields[8]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          008/7-10
        {/if}
      </td>
      <td>1 point if valid coded date exists</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-9">9.</a></td>
      <td>Date (MARC 26X)</td>
      <td width="50%">
        {if isset($fields[9]->paths)}
          {foreach from=$fields[9]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          260$c or 264$c
        {/if}
      </td>
      <td>1 point if 4-digit date exists; 1 point if matches 008 date.</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-10">10.</a></td>
      <td>LC/NLM Classification</td>
      <td width="50%">
        {if isset($fields[10]->paths)}
          {foreach from=$fields[10]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          050, 060, 090
        {/if}
      </td>
      <td>1 point if any field exists</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-11">11.</a></td>
      <td>Subject Headings: Library of Congress</td>
      <td width="50%">
        {if isset($fields[11]->paths)}
          {foreach from=$fields[11]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          600, 610, 611, 630, 650, 651 second indicator 0
        {/if}
      </td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-12">12.</a></td>
      <td>Subject Headings: MeSH</td>
      <td width="50%">
        {if isset($fields[12]->paths)}
          {foreach from=$fields[12]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          600, 610, 611, 630, 650, 651 second indicator 2
        {/if}
      </td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-13">13.</a></td>
      <td>Subject Headings: FAST</td>
      <td width="50%">
        {if isset($fields[13]->paths)}
          {foreach from=$fields[13]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          600, 610, 611, 630, 650, 651 second indicator 7, $2 fast
        {/if}
      </td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-14">14.</a></td>
      <td>Subject Headings: GND<br/>
        (This was not part of the original algorithm)</td>
      <td width="50%">
        {if isset($fields[14]->paths)}
          {foreach from=$fields[14]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          600, 610, 611, 630, 650, 651 second indicator 7, $2 fast
        {/if}
      </td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-15">15.</a></td>
      <td>Subject Headings: Other</td>
      <td width="50%">
        {if isset($fields[15]->paths)}
          {foreach from=$fields[15]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          600, 610, 611, 630, 650, 651, 653 if above criteria are not met
        {/if}
      </td>
      <td>1 point for each field up to 5 total points</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-16">16.</a></td>
      <td>Description</td>
      <td width="50%">
        {if isset($fields[16]->paths)}
          {foreach from=$fields[16]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          008/23=o and 300$a “online resource”
        {/if}
      </td>
      <td>2 points if both elements exist; 1 point if either exists</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-17">17.</a></td>
      <td>Language of Resource</td>
      <td width="50%">
        {if isset($fields[17]->paths)}
          {foreach from=$fields[17]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          008/35-37
        {/if}
      </td>
      <td>1 point if likely language code exists</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-18">18.</a></td>
      <td>Country of Publication Code</td>
      <td width="50%">
        {if isset($fields[18]->paths)}
          {foreach from=$fields[18]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          008/15-17
        {/if}
      </td>
      <td>1 point if likely country code exists</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-19">19.</a></td>
      <td>Language of Cataloging</td>
      <td width="50%">
        {if isset($fields[19]->paths)}
          {foreach from=$fields[19]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          040$b
        {/if}
      </td>
      <td>1 point if either no language is specified, or if English is specified</td>
    </tr>
    <tr>
      <td class="id"><a href="#tt-component-20">20.</a></td>
      <td>Descriptive cataloging standard</td>
      <td width="50%">
        {if isset($fields[20]->paths)}
          {foreach from=$fields[20]->paths item=path name=paths}
            <a href="?tab=completeness#completeness-{$path}">{$path}</a>{if !$smarty.foreach.paths.last}, {/if}
          {/foreach}
        {else}
          040$e
        {/if}
      </td>
      <td>1 point if value is “rda”</td>
    </tr>
  </tbody>
</table>

<h3>components</h3>

<p>The histograms of the individual components:</p>

<table>
{foreach from=$fields key=index item=field}
    <!-- index: {$index}, mod: {$index % 3} -->
  {if $index % 3 == 1}
    <tr>
  {/if}
      <td>
        <svg class="tt-completeness-histogram-chart-{$field->transformed}" width="320" height="200"></svg>
        <p id="tt-component-{$index}">{$index}. {$field->name}</p>
      </td>
  {if $index % 3 == 0 || $index == count($fields)}
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
  var histogramDataUrl = '?tab=histogram&file=tt-completeness-histogram-' + field;
  var histogramSvgClass = "tt-completeness-histogram-chart-" + field;
  displayHistogram(histogramDataUrl, histogramSvgClass);
}

{/literal}
</script>
