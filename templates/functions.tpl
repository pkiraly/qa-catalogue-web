{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="functions" role="tabpanel" aria-labelledby="functions-tab">
      <link rel="stylesheet" href="styles/histogram.css">
      <h2>Functional analysis</h2>
      <h3>{$label}</h3>

      <p>{$text}</p>

      <svg class="histogram-chart" width="960" height="300"></svg>
      <ul>
        <li>y: number of records</li>
        <li>x: number of data elements supporting the function available in a record</li>
      </ul>
      <a>The data elements supporting this function (in the standard there are {$fieldCount} such fields, those which are not linked are not available in the catalogue):
        {foreach $fields as $field name=fields}
          {if isset($field->link)}<a href="?tab=completeness#completeness-{$field->link}">{$field->name}</a>{else}{$field->name}{/if}{if !$smarty.foreach.fields.last},{/if}
        {/foreach}
      </p>
      <script src="js/histogram.js" type="text/javascript"></script>
      <script>
          var db = '{$db}';
          var count = {$count};
          var histogramDataUrl = '?tab=functional-analysis-histogram&function={$function}';
          {literal}
          var units = 'data elements';
          var histogramSvgClass = 'histogram-chart';

          var tooltip = d3.select("body")
              .append("div")
              .style("opacity", 0)
              .attr("class", "tooltip")
              .attr("id", "tooltip")
          displayHistogram(histogramDataUrl, histogramSvgClass);
          {/literal}
      </script>

      <div class="row"><label>Discovery functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-DiscoverySearch" class="bar-chart{if $function == "DiscoverySearch"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=DiscoverySearch">Search</a></p>
          <p class="explanation">Search for a resource corresponding to stated criteria (i.e., to search either a
            single entity or a set of entities using an attribute or relationship of the entity as the search criteria).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-DiscoveryIdentify" class="bar-chart{if $function == "DiscoveryIdentify"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=DiscoveryIdentify">Identify</a></p>
          <p class="explanation">Identify a resource (i.e., to confirm that the entity described or located corresponds
            to the entity sought, or to distinguish between two or more entities with similar characteristics).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-DiscoverySelect" class="bar-chart{if $function == "DiscoverySelect"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=DiscoverySelect">Select</a></p>
          <p class="explanation">Select a resource that is appropriate to the user’s needs (i.e., to choose an entity
            that meets the user’s requirements with respect to content, physical format, etc., or to reject an entity
            as being inappropriate to the user’s needs).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-DiscoveryObtain" class="bar-chart{if $function == "DiscoveryObtain"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=DiscoveryObtain">Obtain</a></p>
          <p class="explanation">Access a resource either physically or electronically through an online connection to
            a remote computer, and/or acquire a resource through purchase, licence, loan, etc.</p>
        </div>
      </div>
      <div class="row"><label>Usage functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-UseRestrict" class="bar-chart{if $function == "UseRestrict"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=UseRestrict">Restrict</a></p>
          <p class="explanation">Control access to or use of a resource (i.e., to restrict access to and/or use of an
            entity on the basis of proprietary rights, administrative policy, etc.).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-UseManage" class="bar-chart{if $function == "UseManage"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=UseManage">Manage</a></p>
          <p class="explanation">Manage a resource in the course of acquisition, circulation, preservation, etc.</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-UseOperate" class="bar-chart{if $function == "UseOperate"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=UseOperate">Operate</a></p>
          <p class="explanation">Operate a resource (i.e., to open, display, play, activate, run, etc. an entity that
            requires specialized equipment, software, etc. for its operation).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-UseInterpret" class="bar-chart{if $function == "UseInterpret"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=UseInterpret">Interpret</a></p>
          <p class="explanation">Interpret or assess the information contained in a resource.</p>
        </div>
      </div>
      <div class="row"><label>Management functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-ManagementIdentify" class="bar-chart{if $function == "ManagementIdentify"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=ManagementIdentify">Identify</a></p>
          <p class="explanation">Identify a record, segment, field, or data element (i.e., to differentiate one logical
            data component from another).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-ManagementProcess" class="bar-chart{if $function == "ManagementProcess"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=ManagementProcess">Process</a></p>
          <p class="explanation">Process a record, segment, field, or data element (i.e., to add, delete, replace,
            output, etc. a logical data component by means of an automated process).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-ManagementSort" class="bar-chart{if $function == "ManagementSort"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=ManagementSort">Sort</a></p>
          <p class="explanation">Sort a field for purposes of alphabetic or numeric arrangement.</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-ManagementDisplay" class="bar-chart{if $function == "ManagementDisplay"} selected{/if}"></svg>
          <p class="title"><a href="?tab=functions&function=ManagementDisplay">Display</a></p>
          <p class="explanation">Display a field or data element (i.e., to display a field or data element with the
            appropriate print constant or as a tracing).</p>
        </div>
      </div>

      <p>The Functional Requirements for Bibliographic Records (FRBR) document's main part defines the primary and
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

  var url = '?tab=functional-analysis-histogram';
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
        console.log(item);
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
        var id = '#bar-chart-' + frbrfunction; //.toLowerCase();

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
