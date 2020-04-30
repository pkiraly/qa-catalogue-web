function displayHistogram(histogramDataUrl, histogramSvgClass) {
  console.log(histogramDataUrl);
  console.log(histogramSvgClass);
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

      // ticks on x axis
      g.append("g")
        .attr("class", "axis axis--x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end")
      ;

      // ticks on y axis
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
