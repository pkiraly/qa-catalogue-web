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

<svg class="serial-histogram-chart" width="960" height="300"></svg>
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
<script>
// $()
var db = '{$db}';
var authoritiesHistogramUrl = 'read-histogram.php?db='+ db + '&file=serial-histogram';
{literal}
var svg = d3.select("svg.serial-histogram-chart"),
  margin = {top: 20, right: 20, bottom: 40, left: 60},
  width = +svg.attr("width") - margin.left - margin.right,
  height = +svg.attr("height") - margin.top - margin.bottom;

var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
    y = d3.scaleLinear().rangeRound([height, 0]);

var g = svg.append("g")
           .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var tooltipSerial = d3.select("body")
  .append("div")
  .style("opacity", 0)
  .attr("class", "tooltip")
  .attr("id", "tooltip-serial")

d3.csv(authoritiesHistogramUrl)
  .then((data) => {
    return data.map((d) => {
      d.frequency = +d.frequency;
      return d;
    });
  })
  .then((data) => {
    x.domain(data.map(function(d) { return d.score; }));
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
              + d.score + ' score';
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
      .attr("x", function(d) { return x(d.score); })
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
{/literal}
</script>