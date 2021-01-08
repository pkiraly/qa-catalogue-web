{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="functions" role="tabpanel" aria-labelledby="functions-tab">
      <h2>Functional analysis</h2>

      <div class="row"><label>Discovery functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-discoverysearch" class="bar-chart"></svg>
          <p class="title">Search</p>
          <p class="explanation">Search for a resource corresponding to stated criteria (i.e., to search either a
            single entity or a set of entities using an attribute or relationship of the entity as the search criteria).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-discoveryidentify" class="bar-chart"></svg>
          <p class="title">Identify</p>
          <p class="explanation">Identify a resource (i.e., to confirm that the entity described or located corresponds
            to the entity sought, or to distinguish between two or more entities with similar characteristics).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-discoveryselect" class="bar-chart"></svg>
          <p class="title">Select</p>
          <p class="explanation">Select a resource that is appropriate to the user’s needs (i.e., to choose an entity
            that meets the user’s requirements with respect to content, physical format, etc., or to reject an entity
            as being inappropriate to the user’s needs).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-discoveryobtain" class="bar-chart"></svg>
          <p class="title">Obtain</p>
          <p class="explanation">Access a resource either physically or electronically through an online connection to
            a remote computer, and/or acquire a resource through purchase, licence, loan, etc.</p>
        </div>
      </div>
      <div class="row"><label>Usage functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-userestrict" class="bar-chart"></svg>
          <p class="title">Restrict</p>
          <p class="explanation">Control access to or use of a resource (i.e., to restrict access to and/or use of an
            entity on the basis of proprietary rights, administrative policy, etc.).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-usemanage" class="bar-chart"></svg>
          <p class="title">Manage</p>
          <p class="explanation">Manage a resource in the course of acquisition, circulation, preservation, etc.</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-useoperate" class="bar-chart"></svg>
          <p class="title">Operate</p>
          <p class="explanation">Operate a resource (i.e., to open, display, play, activate, run, etc. an entity that
            requires specialized equipment, software, etc. for its operation).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-useinterpret" class="bar-chart"></svg>
          <p class="title">Interpret</p>
          <p class="explanation">Interpret or assess the information contained in a resource.</p>
        </div>
      </div>
      <div class="row"><label>Management functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-managementidentify" class="bar-chart"></svg>
          <p class="title">Identify</p>
          <p class="explanation">Identify a record, segment, field, or data element (i.e., to differentiate one logical
            data component from another).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-managementprocess" class="bar-chart"></svg>
          <p class="title">Process</p>
          <p class="explanation">Process a record, segment, field, or data element (i.e., to add, delete, replace,
            output, etc. a logical data component by means of an automated process).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-managementsort" class="bar-chart"></svg>
          <p class="title">Sort</p>
          <p class="explanation">Sort a field for purposes of alphabetic or numeric arrangement.</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-managementdisplay" class="bar-chart"></svg>
          <p class="title">Display</p>
          <p class="explanation">Display a field or data element (i.e., to display a field or data element with the
            appropriate print constant or as a tracing).</p>
        </div>
      </div>

      <p>The Funtional Requirements for Bibliographic Records (FRBR) document's main part defines the primary and
        secondary entities which became famous as FRBR models. Years later Tom Delsey created a mapping
        between the 12 functions and the individual MARC elements.</p>

      <blockquote>
        Tom Delsey (2002)
        <em>Functional analysis of the MARC 21 bibliographic and holdings formats.</em> Tech. report,
        Library of Congress, 2002. Prepared for the Network Development and MARC Standards Office Library of Congress.
        Second Revision: September 17, 2003.
        <a href="https://www.loc.gov/marc/marc-functional-analysis/original_source/analysis.pdf"
           target="_blank">https://www.loc.gov/marc/marc-functional-analysis/original_source/analysis.pdf</a>.
      </blockquote>

      <p>This page shows how these functions are supported by the records. The horizontal axis show the strength of
        the support: something on the left means that support is low so only small portion of the fields support a
        function are available in the records, something on the right means the support is strength. The bars
        represents a range of values. The vertical axis shows the number of records having values in the same range.</p>

      <p>It is experimental because it turned out, that the the mapping covers about 2000 elements (fields, subfields,
        indicatiors etc.), however on an average record there are max several hundred elements, which results that even
        in the best record has about 10-15% of the totality of the elements supporting a given function. So the tool
        doesn't shows you exact numbers, and the scale is not 0-100 but 0-[best score] which is different for every
        catalogue.</p>

    </div>
  </div>
</div>
<script>{literal}
    function loadFunctions() {
        var height = 200,
            width  = 270,
            margin = ({top: 10, right: 10, bottom: 34, left: 40})
        ;

        var url = 'read-functional-analysis-histogram.php?db=' + db;
        var datax = d3
            .csv(url)
            .then(function(data) {
                var filteredData = new Array(12),
                    totals = new Array(12);
                var min = -1,
                    maxX = -1,
                    maxCount = -1;
                for (var i in data) {
                    var item = data[i];
                    if (i == 'columns')
                        continue;

                    var frbrfunction = item.frbrfunction;
                    if (typeof filteredData[item.frbrfunction] === "undefined") {
                        filteredData[item.frbrfunction] = new Array();
                    }
                    var score = parseInt(item.score);
                    var count = parseInt(item.count);
                    if (typeof totals[item.frbrfunction] === 'undefined')
                        totals[item.frbrfunction] = 0;
                    totals[item.frbrfunction] += count

                    filteredData[item.frbrfunction].push({
                        score: score,
                        count: count
                    });

                    if (min == -1 || min > score) {
                        min = score;
                    }
                }

                for (var frbrfunction in filteredData) {
                    var items = new Array();
                    for (i in filteredData[frbrfunction]) {
                        var item = filteredData[frbrfunction][i]
                        percent = item.count * 100 / totals[frbrfunction]
                        if (percent >= 0.5) {
                            item.percent = Math.ceil(percent)
                            items.push(item);
                            if (maxX < item.score) {
                                maxX = item.score;
                                maxCount = item.count
                            }
                        }
                    }
                    filteredData[frbrfunction] = items
                }

                var bandWidth = ((width - margin.right - margin.left) / (maxX - min)) - 1,
                    x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
                    y = d3.scaleLinear().rangeRound([height, 0]);

                var x = d3.scaleBand()
                    .domain([0, maxX])
                    .rangeRound([margin.left, width - margin.right])
                    .padding(0.1)

                var y = d3.scaleLinear()
                    .domain([0, 100])
                    .range([height - margin.bottom, margin.top])

                var scaleX = d3.scaleLinear()
                    .domain([0, maxX])
                    .range([margin.left, width - margin.right])

                var xAxis = function(g) {
                    g.attr("transform", `translate(0,${height - margin.bottom})`)
                        .call(d3.axisBottom(scaleX).tickSizeOuter(0))
                }

                var yAxis = function(g) {
                    g.attr("transform", `translate(${margin.left},0)`)
                        .call(d3.axisLeft(y))
                        .call(g => g.select(".domain").remove())
                }

                var yTitle = function(g) {
                    g.append("text")
                        .attr("font-family", "sans-serif")
                        .attr("font-size", 10)
                        .attr("y", 10)
                        .text("Frequency of records (%)")
                        .attr("transform", "translate(0,5)rotate(-90)")
                        .style("text-anchor", "end")
                        .attr("fill", 'steelblue')
                }

                var xTitle = function(g) {
                    g.append("text")
                        .attr("font-family", "sans-serif")
                        .attr("font-size", 10)
                        .attr("y", height - 3)
                        .attr("x", width - margin.right)
                        .text("Percentage of enabling fields")
                        .style("text-anchor", "end")
                        .attr("fill", 'steelblue')
                }

                for (var frbrfunction in filteredData) {
                    var histogram = filteredData[frbrfunction];
                    var id = '#bar-chart-' + frbrfunction.toLowerCase();

                    var scaleY = d3.scaleLinear()
                        .domain([0, d3.max(histogram, d => d.percent)]).nice()
                        .range([height - margin.bottom, margin.top])

                    const svg = d3.select(id)
                        .attr("viewBox", [0, 0, width, height]);

                    svg.append("g")
                        .attr("fill", "steelblue")
                        .selectAll("rect")
                        .data(histogram)
                        .join("rect")
                        .attr("x", d => {
                            return margin.left + (d.score * bandWidth) - (bandWidth * 0.2);
                        })
                        .attr("y", d => y(d.percent))
                        .attr("height", d => y(0) - y(d.percent))
                        .attr("width", bandWidth);

                    svg.append("g").call(xAxis);
                    svg.append("g").call(yAxis);
                    svg.call(xTitle);
                    svg.call(yTitle);
                }
            });
    }

    $(document).ready(function () {
        loadFunctions()
    });
{/literal}
</script>
{include 'common/html-footer.tpl'}
