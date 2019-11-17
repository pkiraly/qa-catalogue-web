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

<svg class="tt-completeness-histogram-chart-total" width="960" height="300"></svg>
<ul>
  <li>y axis: number of records</li>
  <li>x axis: total score of a record</li>
</ul>

Each record get a score based on a number of criteria.
Each criteria results in a positive score. The final score is
the summary of these criteria scores.

<table>
  <thead>
    <tr>
      <th>Record Element</th>
      <th>MARC field/position/subfield</th>
      <th>How counted</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><a href="#tt-component-1">1.</a> ISBN</td>
      <td>020</td>
      <td>1 point for each occurrence of field</td>
    </tr>
    <tr>
      <td><a href="#tt-component-2">2.</a> Authors</td>
      <td>100, 110, 111</td>
      <td>1 point for each occurrence of field(s)</td>
    </tr>
    <tr>
      <td><a href="#tt-component-3">3.</a> Alternative Titles</td>
      <td>246</td>
      <td>1 point for each occurrence of field</td>
    </tr>
    <tr>
      <td><a href="#tt-component-4">4.</a> Edition</td>
      <td>250</td>
      <td>1 point for each occurrence of field</td>
    </tr>
    <tr>
      <td><a href="#tt-component-5">5.</a> Contributors</td>
      <td>700, 710, 711, 720</td>
      <td>1 point for each occurrence of field(s)</td>
    </tr>
    <tr>
      <td><a href="#tt-component-6">6.</a> Series</td>
      <td>440, 490, 800, 810, 830</td>
      <td>1 point for each occurrence of field(s)</td>
    </tr>
    <tr>
      <td><a href="#tt-component-7">7.</a> Table of Contents and Abstract</td>
      <td>505, 520</td>
      <td>2 points if both fields exist; 1 point if either field exists</td>
    </tr>
    <tr>
      <td><a href="#tt-component-8">8.</a> Date (MARC 008)</td>
      <td>008/7-10</td>
      <td>1 point if valid coded date exists</td>
    </tr>
    <tr>
      <td><a href="#tt-component-9">9.</a> Date (MARC 26X)</td>
      <td>260$c or 264$c</td>
      <td>1 point if 4-digit date exists; 1 point if matches 008 date.</td>
    </tr>
    <tr>
      <td><a href="#tt-component-10">10.</a> LC/NLM Classification</td>
      <td>050, 060, 090</td>
      <td>1 point if any field exists</td>
    </tr>
    <tr>
      <td><a href="#tt-component-11">11.</a> Subject Headings: Library of Congress</td>
      <td>600, 610, 611, 630, 650, 651 second indicator 0</td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td><a href="#tt-component-12">12.</a> Subject Headings: MeSH</td>
      <td>600, 610, 611, 630, 650, 651 second indicator 2</td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td><a href="#tt-component-13">13.</a> Subject Headings: FAST</td>
      <td>600, 610, 611, 630, 650, 651 second indicator 7, $2 fast</td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td><a href="#tt-component-14">14.</a> Subject Headings: GND<br/>
        (This was not part of the original algorithm)</td>
      <td>600, 610, 611, 630, 650, 651 second indicator 7, $2 fast</td>
      <td>1 point for each field up to 10 total points</td>
    </tr>
    <tr>
      <td><a href="#tt-component-15">15.</a> Subject Headings: Other</td>
      <td>600, 610, 611, 630, 650, 651, 653 if above criteria are not met</td>
      <td>1 point for each field up to 5 total points</td>
    </tr>
    <tr>
      <td><a href="#tt-component-16">16.</a> Description</td>
      <td>008/23=o and 300$a “online resource”</td>
      <td>2 points if both elements exist; 1 point if either exists</td>
    </tr>
    <tr>
      <td><a href="#tt-component-17">17.</a> Language of Resource</td>
      <td>008/35-37</td>
      <td>1 point if likely language code exists</td>
    </tr>
    <tr>
      <td><a href="#tt-component-18">18.</a> Country of Publication Code</td>
      <td>008/15-17</td>
      <td>1 point if likely country code exists</td>
    </tr>
    <tr>
      <td><a href="#tt-component-19">19.</a> Language of Cataloging</td>
      <td>040$b</td>
      <td>1 point if either no language is specified, or if English is specified</td>
    </tr>
    <tr>
      <td><a href="#tt-component-20">20.</a> Descriptive cataloging standard</td>
      <td>040$e</td>
      <td>1 point if value is “rda”</td>
    </tr>
    </tbody>
  </table>
<table>

<h3>components</h3>

<p>The histograms of the individual components:</p>

{foreach $fields as $index => $field}
  {if $index % 3 == 0}
      <tr>
  {/if}
    <td>
      <p id="tt-component-{$index+1}">{$index+1}. {$field->name}</p>
      <svg class="tt-completeness-histogram-chart-{$field->transformed}" width="320" height="200"></svg>
    </td>
  {if $index % 3 == 2 || $index == count($fields) - 1}
    </tr>
  {/if}
{/foreach}
</table>

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
  showHistogram(field.transformed);
}

function showHistogram(field) {
  var histogramDataUrl = 'read-histogram.php?db='+ db + '&file=tt-completeness-histogram-' + field;
  var histogramSvgClass = "tt-completeness-histogram-chart-" + field;
  displayHistogram(histogramDataUrl, histogramSvgClass);
}

function displayHistogram(histogramDataUrl, histogramSvgClass) {
  console.log(histogramDataUrl);
  var svg = d3.select("svg." + histogramSvgClass),
    margin = {top: 20, right: 20, bottom: 40, left: 60},
    width = +svg.attr("width") - margin.left - margin.right,
    height = +svg.attr("height") - margin.top - margin.bottom;

  var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
      y = d3.scaleLinear().rangeRound([height, 0]);

  var g = svg.append("g")
             .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  d3.csv(histogramDataUrl)
    .then((data) => {
      return data.map((d) => {
        d.frequency = +d.frequency;
        return d;
      });
    })
    .then((data) => {
      x.domain(data.map(function(d) { return d.count; }));
      y.domain([0, d3.max(data, function(d) { return d.frequency + 1; })]);

      g.append("g")
        .attr("class", "axis axis--x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .selectAll("text")
          .attr("transform", "translate(-10,0)rotate(-45)")
          .style("text-anchor", "end")
      ;

      g.append("g")
        .attr("class", "axis axis--y")
        .call(d3.axisLeft(y).ticks(10))
        .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", "0.71em")
        .attr("text-anchor", "end")
        .text("Frequency");

      var showTooltipSerial = function(d) {
        tooltipSerial
        .transition()
        .duration(200)
        .style("opacity", .9)

        var msg = d.frequency.toLocaleString('en-US') + " records with<br/>"
                + d.count + ' score';
        tooltipSerial
        .html(msg)
        .style("left", getXCoord() + "px")
        .style("top", getYCoord() + "px")
      }

      var moveTooltipSerial = function(d) {
        tooltipSerial
        .style("left", getXCoord() + "px")
        .style("top", getYCoord() + "px")
      }

      var hideTooltipSerial = function(d) {
        tooltipSerial
        .transition()
        .duration(100)
        .style("opacity", 0)
      }

      var getXCoord = function() {
        return d3.event.pageX + 10;
      }

      var getYCoord = function() {
        return d3.event.pageY - 28;
      }

      g.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) { return x(d.count); })
        .attr("y", function(d) { return y(d.frequency); })
        .attr("width", x.bandwidth())
        .attr("height", function(d) { return height - y(d.frequency); })
        .on("mouseover", showTooltipSerial)
        .on("mousemove", moveTooltipSerial)
        .on("mouseleave", hideTooltipSerial)
      ;

      g.selectAll('.tick text')
        .data(data)
        .on('mouseover', showTooltipSerial)
        .on("mousemove", moveTooltipSerial)
        .on("mouseleave", hideTooltipSerial)
      ;
    })
    .catch((error) => {
      console.log('error happened');
      throw error;
    });
}
{/literal}
</script>