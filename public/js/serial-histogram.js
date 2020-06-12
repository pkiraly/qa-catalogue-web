var tooltipSerial = d3.select("body")
  .append("div")
  .style("opacity", 0)
  .attr("class", "tooltip")
  .attr("id", "tooltip-serial")

showHistogram('total', prefix);
for (var i in fields) {
  var field = fields[i];
  showHistogram(field.transformed, prefix);
}

function showHistogram(field, prefix) {
  var histogramDataUrl = '/histogram/?file=' + prefix + '-histogram-' + field;
  var histogramSvgClass = prefix + '-histogram-chart-' + field;
  displayHistogram(histogramDataUrl, histogramSvgClass);
}
