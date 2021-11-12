function displayBarchart(histogramDataUrl, histogramSvgClass, solrField) {
    // console.log(histogramDataUrl);
    // console.log(histogramSvgClass);

    w = d3.select("svg." + histogramSvgClass).attr("width");
    h = d3.select("svg." + histogramSvgClass).attr("height");

    // set the dimensions and margins of the graph
    var margin = {top: 20, right: 30, bottom: 70, left: 400},
        width = w - margin.left - margin.right,
        height = h - margin.top - margin.bottom;

    // append the svg object to the body of the page
    var svg = d3.select("svg." + histogramSvgClass)
        .append("svg")
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
        .append("g")
          .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")")
    ;

    // var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
    //    y = d3.scaleLinear().rangeRound([height, 0]);

    d3.csv(histogramDataUrl)
        .then((data) => {
            return data.map((d) => {
                d.count = +d.count;
                return d;
            });
        })
        .then((data) => {

            // Add X axis
            var x = d3.scaleLinear()
                .domain([0, d3.max(data, function(d) { return d.count; })])
                .range([ 0, width]);
            svg.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x))
                .selectAll("text")
                    .attr("transform", "translate(-10,0)rotate(-45)")
                    .style("text-anchor", "end")
                    .style("font-size", "11pt")
            ;

            // Y axis
            var y = d3.scaleBand()
                .range([ 0, height ])
                .domain(data.map(function(d) { return d.term; }))
                .padding(.1);
            svg.append("g")
                .call(d3.axisLeft(y))
                .selectAll("text")
                    .style("font-size", "11pt")
                    .attr('xlink:href', function (d) {
                        console.log(d)
                        return 'q=' + encodeURI(solrField + ':"' + d + '"');
                    })

            // bars
            svg.selectAll("myRect")
                .data(data)
                .enter()
                .append("rect")
                    .attr("x", x(0) )
                    .attr("y", function(d) { return y(d.term); })
                    .attr("width", function(d) { return x(d.count); })
                    .attr("height", y.bandwidth() )
                    .attr("fill", 'steelblue')
        }
    )
}
