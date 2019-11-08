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
<svg class="authorities-histogram-chart"></svg>
<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>

<script>
// $()
var db = '{$db}';
{literal}
var margin = {top: 20, right: 30, bottom: 30, left: 80},
  width = 960 - margin.left - margin.right,
  height = 300 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
.scale(y)
.orient("left");

var chart = d3.select(".authorities-histogram-chart")
.attr("width", width + margin.left + margin.right)
.attr("height", height + margin.top + margin.bottom)
.append("g")
.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.csv('readCsv.php?db='+ db + '&name=authorities-histogram.csv', type, function(error, data) {
  x.domain(data.map(function(d) { return d.count; }));
  y.domain([
    0,
    d3.max(data, function(d) { return d.frequency; })
  ]);

  chart.append("g")
  .attr("class", "x axis")
  .attr("transform", "translate(0," + height + ")")
  .call(xAxis);

  chart.append("g")
  .attr("class", "y axis")
  .call(yAxis)
  .append("text")
  .attr("transform", "rotate(-90)")
  .attr("y", 6)
  .attr("dy", ".71em")
  .style("text-anchor", "end")
  .text("number of records");

  chart.selectAll(".bar")
  .data(data)
  .enter().append("rect")
  .attr("class", "bar")
  .attr("x", function(d) { return x(d.count); })
  .attr("y", function(d) { return y(d.frequency); })
  .attr("height", function(d) { return height - y(d.frequency); })
  .attr("width", x.rangeBand());
});

function type(d) {
  d.frequency = +d.frequency; // coerce to number
  return d;
}
{/literal}
</script>