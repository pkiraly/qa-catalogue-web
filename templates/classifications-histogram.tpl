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

<svg class="classifications-histogram-chart" width="960" height="300"></svg>
<ul>
  <li>y: number of records</li>
  <li>x: number of subjects in one record</li>
</ul>
<script>
// $()
var db = '{$db}';
var classificationsHistogramUrl = 'read-histogram.php?db='+ db + '&file=classifications-histogram';
{literal}
var svg = d3.select("svg.classifications-histogram-chart"),
  margin = {top: 20, right: 20, bottom: 40, left: 60},
  width = +svg.attr("width") - margin.left - margin.right,
  height = +svg.attr("height") - margin.top - margin.bottom;

var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
  y = d3.scaleLinear().rangeRound([height, 0]);

var g = svg.append("g")
.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.csv(classificationsHistogramUrl)
  .then((data) => {
    return data.map((d) => {
      console.log(d);
      d.frequency = +d.frequency;
      return d;
    });
  })
  .then((data) => {
    x.domain(data.map(function(d) { return d.count; }));
    y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

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

    g.selectAll(".bar")
      .data(data)
      .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.count); })
      .attr("y", function(d) { return y(d.frequency); })
      .attr("width", x.bandwidth())
      .attr("height", function(d) { return height - y(d.frequency); });
  })
  .catch((error) => {
    console.log('error happened');
    throw error;
  });
{/literal}
</script>