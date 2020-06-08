<?php
/* Smarty version 3.1.33, created on 2019-11-15 15:24:16
  from '/home/kiru/git/metadata-qa-marc-web/templates/authorities-histogram.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dceb51045d957_29713489',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4bd8a5b91e000505f1c4dc92ea794b66628d1f89' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/authorities-histogram.tpl',
      1 => 1573827847,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dceb51045d957_29713489 (Smarty_Internal_Template $_smarty_tpl) {
?><h3>histogram</h3>

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

<svg class="authorities-histogram-chart" width="960" height="300"></svg>
<ul>
  <li>y: number of records</li>
  <li>x: number of authority names in one record</li>
</ul>
<?php echo '<script'; ?>
>
// $()
var db = '<?php echo $_smarty_tpl->tpl_vars['db']->value;?>
';
var authoritiesHistogramUrl = 'read-histogram.php?db='+ db + '&file=authorities-histogram';

var svg = d3.select("svg.authorities-histogram-chart"),
  margin = {top: 20, right: 20, bottom: 40, left: 60},
  width = +svg.attr("width") - margin.left - margin.right,
  height = +svg.attr("height") - margin.top - margin.bottom;

var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
    y = d3.scaleLinear().rangeRound([height, 0]);

var g = svg.append("g")
           .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var tooltipAuthorities = d3.select("body")
  .append("div")
  .style("opacity", 0)
  .attr("class", "tooltip")
  .attr("id", "tooltip-authorities")

d3.csv(authoritiesHistogramUrl)
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

    var showTooltipAuthorities = function(d) {
      tooltipAuthorities
      .transition()
      .duration(200)
      .style("opacity", .9)

      var msg = d.frequency.toLocaleString('en-US') + " records with<br/>"
              + d.count + ' classifications';
      tooltipAuthorities
      .html(msg)
      .style("left", getXCoord() + "px")
      .style("top", getYCoord() + "px")
    }

    var moveTooltipAuthorities = function(d) {
      tooltipAuthorities
      .style("left", getXCoord() + "px")
      .style("top", getYCoord() + "px")
    }

    var getXCoord = function() {
      return d3.event.pageX + 10;
    }

    var getYCoord = function() {
      return d3.event.pageY - 28;
    }

    var hideTooltipAuthorities = function(d) {
      tooltipAuthorities
      .transition()
      .duration(100)
      .style("opacity", 0)
    }

    g.selectAll(".bar")
      .data(data)
      .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.count); })
      .attr("y", function(d) { return y(d.frequency); })
      .attr("width", x.bandwidth())
      .attr("height", function(d) { return height - y(d.frequency); })
      .on("mouseover", showTooltipAuthorities)
      .on("mousemove", moveTooltipAuthorities)
      .on("mouseleave", hideTooltipAuthorities)
    ;

    g.selectAll('.tick text')
      .data(data)
      .on('mouseover', showTooltipAuthorities)
      .on("mousemove", moveTooltipAuthorities)
      .on("mouseleave", hideTooltipAuthorities)
    ;

  })
  .catch((error) => {
    console.log('error happened');
    throw error;
  });

<?php echo '</script'; ?>
><?php }
}
