<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>QA catalogue for analysing library data</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <!-- script src="//use.fontawesome.com/feff23b961.js"></script -->
  <script src="feff23b961.js"></script>
  <script src="//code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="metadata-qa.css">
  <script type="text/javascript">

    var db = 'cerl';
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('db')) {
      db = urlParams.get('db');
    } else {
      db = window.location.pathname.replace(/\//g, '');
    }
    var marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
    var solrProxy = 'solr-proxy.php';
    var solrDisplay = 'solr-display.php';

    function showMarcUrl(link) {
      return marcBaseUrl + link;
    }
  </script>
  <script src="configuration.js" type="text/javascript"></script>
  <script src="loadFacets.php" type="text/javascript"></script>
  <script src="https://d3js.org/d3.v5.min.js"></script>
</head>
<body>
<div class="container">
  <!-- Content here -->
  <h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
  <p>
    <i class="fa fa-book" aria-hidden="true"></i>
    <script type="text/javascript">
      if (db == 'szte') {
        document.write('<a href="http://www.ek.szte.hu/" target="_blank">A Szegedi Tudományegyetem Klebelsberg Kuno Könyvtára</a>');
      } else if (db == 'mokka') {
        document.write('<a href="http://mokka.hu/" target="_blank">mokka &mdash; Magyar Országos Közös Katalógus</a>');
      } else if (db == 'cerl') {
        document.write('<a href="https://www.cerl.org/resources/hpb/main/" target="_blank">The Heritage of the Printed Book Database</a>');
      } else if (db == 'dnb') {
        document.write('<a href="https://www.dnb.de/" target="_blank">Deutsche Nationalbibliothek</a>');
      } else if (db == 'gent') {
        document.write('<a href="https://www.dnb.de/" target="_blank">Universiteitsbibliotheek Gent</a>');
      } else if (db == 'loc') {
        document.write('<a href="https://catalog.loc.gov/" target="_blank">Library of Congress</a>');
      } else if (db == 'mtak') {
          document.write('<a href="https://mtak.hu/" target="_blank">Magyar Tudományos Akadémia Könyvtára</a>');
      } else if (db == 'bayern') {
          document.write('<a href="https://www.bib-bvb.de/" target="_blank">Verbundkatalog B3Kat des Bibliotheksverbundes Bayern (BVB) und des Kooperativen Bibliotheksverbundes Berlin-Brandenburg (KOBV)</a>');
      } else if (db == 'bnpl') {
          document.write('<a href="https://bn.org.pl/" target="_blank">Biblioteka Narodowa (Polish National Library)</a>');
      } else if (db == 'nfi') {
        document.write('<a href="https://www.kansalliskirjasto.fi/en" target="_blank">Kansallis Kirjasto/National Biblioteket (The National Library of Finnland)</a>');
      }
    </script>
  </p>

  <!-- Nav tabs -->
  <nav>
  <ul class="nav nav-tabs" id="myTab">
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="data-tab" href="#data" aria-controls="data">Data</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
         id="completeness-tab" href="#completeness" aria-controls="completeness">Completeness</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="issues-tab" href="#issues" aria-controls="issues">Issue catalog</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="functions-tab" href="#functions" aria-controls="functions">
        Functional analysis
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="classifications-tab" href="#classifications" aria-controls="classifications">
        Subject analysis
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
        id="terms-tab" href="#terms" aria-controls="terms">
        Terms
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="settings-tab" href="#settings" aria-controls="settings">Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="about-tab" href="#about" aria-controls="about">About</a>
    </li>
  </ul>
  </nav>

  <!-- Tab panes -->
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane" id="data" role="tabpanel" aria-labelledby="data-tab">
      <div class="container" id="content">
        <div class="row">
          <div id="left" class="col-3">
            <div class="search-block">
              <h3>Search</h3>
              <form id="search">
                <input type="text" name="query" id="query" value="*:*">
                <i class="fa fa-search" aria-hidden="true"></i>
              </form>
            </div>
            <div id="filters" class="filter-block">
              <h3>Filters</h3>
              <div id="filter-list"></div>
            </div>

            <div id="facets" class="facet-block">
              <h3>Facets</h3>
              <div id="facet-list"></div>
            </div>
          </div>
          <div id="main" class="col">
            <div class="row">
              <div class="col-8">
                Found <span id="numFound"></span> records
              </div>
              <div class="col-4" id="message"></div>
            </div>

            <div class="row" id="navigation">
              <div class="col-8" id="prev-next"></div>
              <div class="col-4" id="per-page">
                <span class="label">Items per page:</span>
                <span id="items-per-page"></span>
              </div>
            </div>

            <div id="records"></div>

            <div class="row" id="navigation-footer">
              <div class="col-8" id="prev-next-footer"></div>
              <div class="col-4"></div>
            </div>
            <div id="solr-url"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane active" id="completeness" role="tabpanel"
         aria-labelledby="completeness-tab">
      <h2>Completeness of MARC21 field groups</h2>
      <div id="completeness-group-table"></div>
      <h2>Completeness of MARC21 fields</h2>
      <div id="completeness-field-table"></div>
    </div>
    <div class="tab-pane" id="issues" role="tabpanel" aria-labelledby="issues-tab">
      <h2>Issues in MARC21 records</h2>
      <div id="issues-table-placeholder"></div>
    </div>
    <div class="tab-pane" id="functions" role="tabpanel" aria-labelledby="functions-tab">
      <h2>Functional analysis</h2>

      <div class="row"><label>Discovery functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-DiscoverySearch" class="bar-chart"></svg>
          <p>Search</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-DiscoveryIdentify" class="bar-chart"></svg>
          <p>Identify</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-DiscoverySelect" class="bar-chart"></svg>
          <p>Select</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-DiscoveryObtain" class="bar-chart"></svg>
          <p>Obtain</p>
        </div>
      </div>
      <div class="row"><label>Usage functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-UseRestrict" class="bar-chart"></svg>
          <p>Restrict</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-UseManage" class="bar-chart"></svg>
          <p>Manage</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-UseOperate" class="bar-chart"></svg>
          <p>Operate</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-UseInterpret" class="bar-chart"></svg>
          <p>Interpret</p>
        </div>
      </div>
      <div class="row"><label>Management functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-ManagementIdentify" class="bar-chart"></svg>
          <p>Identify</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-ManagementProcess" class="bar-chart"></svg>
          <p>Process</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-ManagementSort" class="bar-chart"></svg>
          <p>Sort</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-ManagementDisplay" class="bar-chart"></svg>
          <p>Display</p>
        </div>
      </div>

      <style>
        .bar-chart {
          height: 100px;
          width: 270px;
          border: 1px solid #37ba00;
        }
        .bar-chart g rect {
          background-color: #37ba00;
        }
        #functions div.row label {
          font-weight: bold;
        }
      </style>
    </div>
    <div class="tab-pane" id="classifications" role="tabpanel" aria-labelledby="classifications-tab">
      <h2>Subject analysis</h2>
      <div id="classifications-content"></div>
    </div>
    <div class="tab-pane" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>Terms</h2>
      <div id="terms-scheme" data-facet="" data-query=""></div>
      <div id="terms-content"></div>
    </div>
    <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
      <a href="#" id="set-facets">set facets</a>
      <div id="set-facet-list"></div>
    </div>
    <div class="tab-pane" id="about" role="tabpanel" aria-labelledby="about-tab">
      <div>
        <p>
          This experimental website is part of a research project called Measuring Metadata Quality
          conducted by Péter Király. You can read more about the research at
          <a href="https://pkiraly.github.io" target="_blank">pkiraly.github.io</a>.
        </p>

        <p>
          Credits<br/>
          I would like to thank the experts I have consulted: Rudolf Ungváry (retired, Hungarian National Library, HU),
          Gerard Coen (DANS and ISKO-NL, NL), Andreas Ledl (BARTOC and Uni Basel, CH), Anna Kasprzik (ZBW, DE),
          Jakob Voß (GBV, DE), Uma Balakrishnan (GBV, DE), Yann Y. Nicolas (ABES, FR),
          Michael Franke-Maier (Freie Universität Berlin, DE), Gerhard Lauer (Uni Basel, CH).
        </p>

        <p>This is an open source project. You can find the code at:</p>
        <ul>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc" target="_blank">Backend (Java)</a></li>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc-web" target="_blank">Frontend (PHP)</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="js/handlebars.min.js"></script>
<!-- handlebars.runtime-v4.1.1.js -->

<script id="filter-param-template" type="text/x-handlebars-template">fq={{field}}:"{{value}}"</script>
<script id="filter-all-param-template" type="text/x-handlebars-template">fq={{field}}:*</script>

<script id="list-filters-template" type="text/x-handlebars-template">
  {{#list filters}}<a href="#" data="{{param}}"><i class="fa fa-minus" aria-hidden="true"></i></a> {{label}}{{/list}}
</script>

<script id="item-prev-next-template" type="text/x-handlebars-template">
  <a href="#" data="{{start}}">{{label}}</a>
</script>

<script id="strong-template" type="text/x-handlebars-template">
  <strong>{{item}}</strong>
</script>

<script type="text/javascript">
  var query = '*:*';
  var start = 0;
  var rows = 10;
  var filters = [];
  var facetLimit = 10;
  var facetOffsetParameters = [];

  var defaultFacets = [
    '041a_Language_ss',
    '040b_AdminMetadata_languageOfCataloging_ss',
    'Leader_06_typeOfRecord_ss',
    'Leader_18_descriptiveCatalogingForm_ss'
  ];

  var facets = defaultFacets;
  if (typeof selectedFacets != 'undefined')
    facets = selectedFacets;

  var parameters = [
    'wt=json',
    'json.nl=map',
    'json.wrf=?',
    'facet=on',
    'facet.limit=' + facetLimit
    // 'facet.field=ManifestationIdentifier_ss',
    // 'facet.field=9129_WorkIdentifier_ss',
    // 'facet.field=041a_Language_ss',
    // 'facet.field=040b_AdminMetadata_languageOfCataloging_ss',
    // 'facet.field=Leader_06_typeOfRecord_ss',
    // 'facet.field=Leader_18_descriptiveCatalogingForm_ss'
  ];

  var facetLabels = {
    '041a_Language_ss': 'language',
    '040b_AdminMetadata_languageOfCataloging_ss': 'language of cataloging',
    'Leader_06_typeOfRecord_ss': 'record type',
    'Leader_18_descriptiveCatalogingForm_ss': 'cataloging form',
    '650a_Topic_topicalTerm_ss': 'topic',
    '650z_Topic_geographicSubdivision_ss': 'geographic',
    '650v_Topic_formSubdivision_ss': 'form',
    '6500_Topic_authorityRecordControlNumber_ss': 'topic id',
    '6510_Geographic_authorityRecordControlNumber_ss': 'geo id',
    '6550_GenreForm_authorityRecordControlNumber_ss': 'genre id',
    '9129_WorkIdentifier_ss': 'work id',
    '9119_ManifestationIdentifier_ss': 'manifestation id'
  };

  Handlebars.registerHelper('list', function(items, options) {
    var out = '<ul>';
    for(var i=0, l=items.length; i<l; i++) {
      out = out + '<li>' + options.fn(items[i]) + '</li>';
    }
    return out + '</ul>';
  });

  var filterParamTemplate = Handlebars.compile($("#filter-param-template").html());
  var filterAllParamTemplate = Handlebars.compile($("#filter-all-param-template").html());
  var filterTemplate      = Handlebars.compile($("#list-filters-template").html());
  var itemPrevNextTemplate= Handlebars.compile($("#item-prev-next-template").html());
  var strong              = Handlebars.compile($("#strong-template").html());

  function getFacetLabel(facet) {
    if (typeof facetLabels[facet] != "undefined")
      return facetLabels[facet];
    return facet.replace(/_ss$/, '').replace(/_/g, ' ');
  }

  function buildFacetParameters() {
    var facetParameters = [];
    for (var i in facets) {
      facetParameters.push('facet.field=' + facets[i]);
    }
    if (facetParameters.length > 0) {
      facetParameters.push('facet.mincount=1');
    }
    return facetParameters;
  }

  function buildFacetNavigationParameters() {
    var facetParameters = [];
    facetParameters.push('facet.mincount=1');
    for (var i in facetOffsetParameters) {
      facetParameters.push('facet.field=' + i);
      facetParameters.push('f.' + i + '.facet.offset=' + facetOffsetParameters[i]);
    }
    return facetParameters;
  }

  function buildUrl() {

    var url = solrDisplay // solrProxy // baseUrl
      + '?q=' + query
      + '&' + parameters.join('&')
      + '&' + buildFacetParameters().join('&')
      + '&start=' + start
      + '&rows=' + rows
      + '&core=' + db
    ;

    if (filters.length > 0)
      for (var i = 0; i < filters.length; i++)
        url += '&' + filters[i].param;

    return url;
  }

  function buildFacetNavigationUrl() {

    var url = solrDisplay // solrProxy // baseUrl
      + '?q=' + query
      + '&' + parameters.join('&')
      + '&' + buildFacetNavigationParameters().join('&')
      + '&rows=0'
      + '&core=' + db
    ;

    if (filters.length > 0)
      for (var i = 0; i < filters.length; i++)
        url += '&' + filters[i].param;

    return url;
  }

  function updateFilterBlock() {
    $('#filter-list').html(filterTemplate({'filters': filters}));
    $('#filter-list a').click(function (e) {
      var filter = $(this).attr('data');
      var index = -1;
      for (var i = 0; i < filters.length; i++) {
        if (filters[i].param == filter) {
          index = i;
          break;
        }
      }
      if (index != -1) {
        filters.splice(index, 1);
        start = 0;
        loadDataTab(buildUrl());
      }
    })
  }

  function createPrevNextLinks(numFound) {
    $('#prev-next').html('');
    $('#prev-next-footer').html('');
    var items = [];
    var item;
    if (start > 0) {
      for (var i = 1; i <= 3; i++) {
        item = start - (i * rows);
        if (item >= 0)
          items.unshift(itemPrevNextTemplate(
            {'start': item, 'label': getInterval(item, numFound, false)}));
      }
    }
    items.push(strong({'item': getInterval(start, numFound, true)}));
    for (var i = 1; i <= 3; i++) {
      item = parseInt(start) + (i * rows);
      if (item+1 < numFound)
        items.push(itemPrevNextTemplate(
          {'start': item, 'label': getInterval(item, numFound, false)}));
    }
    $('#prev-next').html(items.join(' &nbsp; '));
    $('#prev-next-footer').html(items.join(' &nbsp; '));
    $('#prev-next a').click(function (event) {
      event.preventDefault();
      start = $(this).attr('data');
      loadDataTab(buildUrl());
    });
    $('#prev-next-footer a').click(function (event) {
      event.preventDefault();
      start = $(this).attr('data');
      loadDataTab(buildUrl());
    });
  }

  function getInterval(number, max, both) {
    var beginning = parseInt(number) + 1;
    var startEnd = beginning + '-';
    if (both === true) {
      var ending = parseInt(number) + parseInt(rows);
      if (ending > max)
        ending = max;
      startEnd += ending;
    }
    return startEnd;
  }

  function createMarcView(id, jsonString) {
    var marc = eval('(' + jsonString + ')');
    var tags = sortTags(marc);

    var rows = [];
    for (var tagId in tags) {
      var tag = tags[tagId];
      if (tag.match(/^00/) || tag == 'leader') {
        rows.push([tag, '', '', '', marc[tag]]);
      } else {
        var value = marc[tag];
        var firstRow = [tag, value.ind1, value.ind2];
        var i = 0;
        for (var code in value.subfields) {
          i++;
          if (i == 1) {
            firstRow.push('$' + code, value.subfields[code]);
            rows.push(firstRow);
          } else {
            rows.push(['', '', '', '$' + code, value.subfields[code]]);
          }
        }
      }
    }
    var trs = [];
    for (var i in rows) {
      trs.push('<tr><td>' + rows[i].join('</td><td>') + '</td></tr>');
    }
    var marcTable = '<table>' + trs.join('') + '</table>';
    $('#marc-details-' + id).html(marcTable)
  }

  function sortTags(marc) {
    var tags = [];
    for (var tag in marc) {
      if (tag != 'leader')
        tags.push(tag);
    }
    tags.sort();
    tags.unshift('leader');
    return tags;
  }

  function setFacetClickBehaviour() {
    $('div#facets ul a.facet-term').click(function (e) {
      console.log('facet-term->click()');
      var field = $(this).parent().parent().parent().attr('id');
      var value = $(this).html();
      var filterParam = filterParamTemplate({'field': field, 'value': value});
      filters.push({
        'param': filterParam,
        'label': getFacetLabel(field) + ': ' + value
      });
      start = 0;
      loadDataTab(buildUrl());
    });
  }

  function setFacetNavigationClickBehaviour() {
    console.log('setFacetNavigationClickBehaviour');
    $('div.facet-block ul a.facet-up').click(function (event) {
      event.preventDefault();
      console.log('facet-up->click()');
      var field = $(this).attr('data-field');
      var offset = parseInt($(this).attr('data-offset'));
      facetOffsetParameters[field] = (offset > 10) ? offset - 10 : 0;
      loadFacetNavigation(field);
    });
    $('div.facet-block ul a.facet-down').click(function (event) {
      event.preventDefault();
      console.log('facet-down->click()');
      var field = $(this).attr('data-field');
      var offset = parseInt($(this).attr('data-offset'));
      facetOffsetParameters[field] = offset + 10;
      loadFacetNavigation(field);
    });
  }

  function loadFacetNavigation(field) {
    var url = buildFacetNavigationUrl();
    $.ajax(url)
     .done(function(result) {
       $('#' + field).html(result.facets);
       setFacetClickBehaviour();
       setFacetNavigationClickBehaviour();
     });
  }

  function loadDataTab(urlParam) {
    $('#message').html('<i class="fa fa-spinner" aria-hidden="true"></i> loading...');

    if (filters.length > 0) {
      updateFilterBlock();
    } else {
      $('#filter-list').html('');
    }

    $.ajax(urlParam)
      .done(function(result) {
        $('#numFound').html(result.numFound.toLocaleString('en-US'));
        $('#solr-url').html(urlParam);
        createPrevNextLinks(result.numFound);

        $('#records').html(result.records);
        showRecordDetails();
        $('#facet-list').html(result.facets);
        setFacetClickBehaviour();
        setFacetNavigationClickBehaviour();
        $('#message').html('');
        $('a[aria-controls="marc-issue-tab"]').click(function (e) {
          var id = $(this).attr('data-id');
          console.log('id: ' + id);
          var url = 'read-record-issues.php?db=' + db + '&id=' + id + '&display=1';
          console.log('getting url: ' + url);
          $.ajax(url)
            .done(function(result) {
              console.log('retrieving url: ' + url);
              $('#marc-issue-' + id).html(result);
            });
        });
      })
      .fail(function() {
        alert("error");
      });
  }

  function showRecordDetails() {
    $('.record h2 a.record-details').click(function (event) {
      event.preventDefault();
      var detailsId = $(this).attr('data');
      console.log(detailsId);
      $('#' + detailsId).toggle();
    });

    $('.record-link').click(function (event) {
      event.preventDefault();
      var field = $(this).attr('data');
      var value = $(this).html();
      var filterParam = filterParamTemplate({'field': field, 'value': value});
      filters.push({
        'param': filterParam,
        'label': getFacetLabel(field) + ': ' + value
      });
      start = 0;
      loadDataTab(buildUrl());
    });
  }

  function doSearch() {
    query = $('#query').val();
    start = 0;
    loadDataTab(buildUrl());
  }

  function itemsPerPage() {
    var items = [];
    var numbers = [10, 25, 50, 100];
    for (var i in numbers) {
      var number = numbers[i];
      if (number === rows)
        items.push(strong({'item': number}));
      else
        items.push(itemPrevNextTemplate({
          'start': number, 'label': number}));
    }
    $('#items-per-page').html(items.join(' '));
    $('#items-per-page a').click(function (event) {
      event.preventDefault();
      start = 0;
      rows = $(this).attr('data');
      itemsPerPage();
      loadDataTab(buildUrl());
    });
  }

  function setFacets() {
    $('#set-facet-list').html('<h3>Set facets</h3>');
    $.getJSON('listFields.php?db=' + db, function(result, status) {
      var htmlForm = '<form id="facetselection">';
      for (var item in result) {
        var facet = result[item];
        var isInUse = jQuery.inArray(facet, facets) > -1;
        var checked = isInUse ? ' checked="checked"' : '';
        htmlForm += '<input type="checkbox"'
          + ' value="' + facet + '"'
          + ' name="facet"'
          + ' id="' + facet + '"'
          + checked
          + '> '
          + '<label for="' + facet +'">' + facet + '</label><br/>'
        ;
      }
      htmlForm += '<input type="submit" value="save" id="save-facet-change" />';
      htmlForm += '</form>';
      $('#set-facet-list').append(htmlForm);

      setFacetSelectionHandlers();
    });
  }

  function setFacetSelectionHandlers() {
    // $('#facet-selection :checkbox').change(function (){
    $('input[type="checkbox"]').change(function () {
      if (this.name == 'facet') {
        var facet = this.value;
        if (this.checked) {
          facets.push(facet);
        } else {
          var pos = jQuery.inArray(facet, facets);
          if (pos > -1)
            facets.splice(pos, 1);
        }
      }
    });

    $('#facetselection').submit(function(event) {
      event.preventDefault();
      var checkValues = $('input[name=facet]:checked').map(function() {
        return this.value;
      }).get().join(',');

      $.post("saveFacets.php", {facet: checkValues, db: db}, function(result){
        $("#message").html("saved");
      });
      doSearch();
    });
  }

  function openType(t) {
    $('tr.t-' + t).toggle();
  }

  function searchForField(field) {
    var filterParam = filterAllParamTemplate({'field': field});
    filters = [];
    filters.push({
      'param': filterParam,
      'label': getFacetLabel(field) + ': *'
    });
    start = 0;
    loadDataTab(buildUrl());
    resetTabs();
    $('#myTab a[href="#data"]').tab('show');
  }

  function loadCompleteness() {
    $.get('read-packages.php?db=' + db + '&display=1')
    .done(function(data) {
      $('#completeness-group-table').html(data);
    });
    $.get('read-completeness.php?db=' + db + '&display=1')
     .done(function(data) {
       $('#completeness-field-table').html(data);
     });
  }

  function loadCompletenessOld() {
    $.get('read-completeness.php?db=' + db)
      .done(function(data) {
        var fieldNames = [
          'path','label','','count','%','count','min','max','mean','stddev'
        ]; // ,'histogram'
        var htmlRow = [];
        for (var field in fieldNames) {
          var classAttr = '';
          if (field < 3) {
            classAttr = ' class="left"';
          } else if (fieldNames[field] == 'count') {
            classAttr = ' class="bordered-left"';
          } else if (fieldNames[field] == 'stddev') {
            classAttr = ' class="bordered-right"';
          }
          htmlRow.push('<th' + classAttr + '>' + fieldNames[field] + '</th>');
        }
        var header = '<tr class="first">'
          + '<th colspan="3"></th>'
          + '<th colspan="2" class="with-border">records</th>'
          + '<th colspan="5" class="with-border">occurences</th>'
          + '</tr>'
          + '<tr class="second">' + htmlRow.join('') + '</tr>';
        var previousPackage = '';
        var previousTag = '';

        var rows = [];
        for (var i in data.records) {
          var rowData = data.records[i];
          var htmlRow = [];
          var percent = 0;
          for (var field in rowData) {
            if (field == 'package') {
              var currentPackage = rowData['package'];
              if (currentPackage != previousPackage)
                rows.push('<tr><td colspan="5" class="package">[' + currentPackage + ']</td></tr>');
              previousPackage = currentPackage;
            } else if (field == 'tag') {
              var currentTag = rowData['tag'];
              if (currentTag != previousTag)
                rows.push('<tr><td colspan="5" class="tag">'
                  + rowData['path'].substr(0, 3) + ' &mdash; ' + currentTag
                  + '</td></tr>');
              previousTag = currentTag;
            } else if (field == 'histogram' || field == 'solr') {
            } else {
              if (field == 'number-of-record') {
                percent = rowData[field] / data.max;
                htmlRow.push(
                  '<td class="chart">'
                  + '<div style="width: ' + (percent * 200) + 'px;">&nbsp;</div>'
                  + '</td>'
                );
              }
              if (field == 'path') {
                var content = rowData[field].substr(3);
                if (rowData['solr'] != undefined) {
                  var query = rowData['solr'] + ':*';
                  content = '<a href="javascript:searchForField(\'' + rowData['solr'] + '\')">' + content + '</a>';
                }
                htmlRow.push('<td class="' + field + '">' + content + '</td>');
              } else {
                htmlRow.push('<td class="' + field + '">' + rowData[field] + '</td>');
              }
              if (field == 'number-of-record') {
                htmlRow.push('<td class="' + field + '">' + (percent * 100).toFixed(2) + '%</td>');
              }
            }
          }
          rows.push('<tr>' + htmlRow.join('') + '</tr>');
        }

        var table = '<table>'
          + '<thead>' + header + '</thead>'
          + '<tbody>' + rows.join('') + '</tbody>'
          + '</table>';
        $('#completeness-field-table').html(table);
      });
  }

  function loadIssues() {
    $.get('read-issue-summary.php?db=' + db + '&display=1')
      .done(function(data) {
        $('#issues-table-placeholder').html(data);
        loadIssueHandlers();
      });
  }

  function loadIssuesDOM() {
    $.get('read-issue-summary.php?db=' + db)
      .done(function(data) {
        var fieldNames = ['path', 'message', 'url', 'count']; // ,'histogram'
        var htmlRow = [];
        for (var field in fieldNames) {
          var classAttr = '';
          var name = fieldNames[field] == 'message'
            ? 'value/explanation' : fieldNames[field];
          htmlRow.push('<th' + classAttr + '>' + name + '</th>');
        }
        var header = '<tr>' + htmlRow.join('') + '</tr>';
        var numberFormat = new Intl.NumberFormat('en-UK');

        var rows = [];
        var typeCounter = 0;
        for (var typeId in data.types) {
          var type = data.types[typeId];
          var typeRows = [];
          typeCounter++;
          var records = data.records[type];
          var totalCount = 0;
          for (var i in records) {
            var rowData = records[i];
            var htmlRow = [];
            var percent = 0;
            for (var field in rowData) {
              var content = rowData[field];
              if (field == 'count') {
                totalCount += parseInt(content);
                content = '<a href="#"'
                  + ' data-type="' + type + '"'
                  + ' data-path="' + rowData['path'] + '"'
                  + ' data-message="' + rowData['message'] + '">'
                  + numberFormat.format(content)
                  + '</a>';
              } else if (field == 'url') {
                if (!content.match(/^http/)) {
                  content = showMarcUrl(content);
                }
                content = '<a href="' + content + '" target="_blank">'
                  + '<i class="fa fa-info" aria-hidden="true"></i></a>';
              } else if (field == 'message') {
                if (content.match(/^ +$/)) {
                  content = '"' + content + '"';
                }
              } else if (field == 'path') {
              }

              htmlRow.push('<td class="' + field + '">' + content + '</td>');
            }
            var typeRow = '<tr class="t t-' + typeCounter + '">'
              + htmlRow.join('')
              + '</tr>';
            typeRows.push(typeRow);
          }

          var typeHeadRow = '<tr>'
            + '<td colspan="3" class="type"><span class="type">' + type + '</span>'
            + ' (' + data.typeCounter[type].variations + ' variants)'
            + ' <a href="javascript:openType(' + typeCounter + ')">[+]</a>'
            + '</td>'
            + '<td class="count">' + numberFormat.format(data.typeCounter[type].count) + '</td>'
            + '</tr>';
          rows.push(typeHeadRow);
          rows = rows.concat(typeRows);
        }

        var table = '<table id="issues-table">'
          + '<thead>' + header + '</thead>'
          + '<tbody>' + rows.join('') + '</tbody>'
          + '</table>';
        $('#issues-table-placeholder').html(table);
        loadIssueHandlers();
      });
  }

  function loadIssueHandlers() {
    $('#issues-table-placeholder tr.t td.count a').hover(
      function () {
        $(this).attr('title', 'show records records having this issue (max 10 records)');
      },
      function () {
        $(this).find("span:last").remove();
      }
    );

    $('#issues-table-placeholder tr.t td.count a').on('click', function (e) {
      var query = {'db': db};
      query.errorId = $(this).attr('data-id');
      var issueDetailsUrl = 'read-issue-collector.php'
      $.get(issueDetailsUrl, query)
       .done(function (data) {
         var query = 'id:("' + data.recordIds.join('" OR "') + '")';
         $('#query').val(query);
         resetTabs();
         $('#myTab a[href="#data"]').tab('show');
         doSearch();
       });
    });
  }

  function loadClassifications() {
    $.getJSON('read-classifications.php?db=' + db, function(result, status) {
      $('#classifications-content').html(result.byRecord);
      $('#classifications-content').append(result.byField);
      setClassificationLinkHandlers();
    });
  }

  function setClassificationLinkHandlers() {
    $('a.term-link').click(function(event) {
      event.preventDefault();
      var facet = $(this).attr('data-facet');
      var termQuery = $(this).attr('data-query');
      var scheme = $(this).attr('data-scheme');

      var url = solrDisplay
          + '?q=' + termQuery
          + '&facet=on'
          + '&facet.limit=100'
          + '&facet.field=' + facet
          + '&facet.mincount=1'
          + '&core=' + db
          + '&rows=0'
          + '&wt=json'
          + '&json.nl=map'
      ;

      $.getJSON(url, function(result, status) {
        $('#terms-content').html(result.facets);
        $('#terms-scheme').html(scheme);
        $('#terms-scheme').attr('data-facet', facet);
        $('#terms-scheme').attr('data-query', termQuery);
        resetTabs();
        $('#myTab a[href="#terms"]').tab('show');

        $('#terms-content a.facet-term').click(function(event) {
          var term = $(this).html();
          var facet = $('#terms-scheme').attr('data-facet');
          var fq = $('#terms-scheme').attr('data-query');
          query = facet + ':%22' + term + '%22';
          $('#query').val(query);
          filters = [];
          filters.push({
            'param': 'fq=' + fq,
            'label': clearFq(fq)
          });
          start = 0;
          var url = buildUrl();
          loadDataTab(url);
          resetTabs();
          $('#myTab a[href="#data"]').tab('show');
        });
      });
    });
  }

  function clearFq(fq) {
    return fq.replace(/_ss:/g, ':').replace(/%22/g, '"').replace(/_/g, ' ').replace(/:/, ': ');
  }

  function loadTerms() {
    console.log('loadTerms');
  }

  function loadFunctions() {
    var height = 100,
        width  = 270,
        margin = ({top: 0, right: 0, bottom: 0, left: 0})
    ;

    var url = 'read-functional-analysis-histogram.php?db=' + db;
    var datax = d3
      .csv(url)
      .then(function(data) {
        var filteredData = new Array(12);
        var min = -1,
            max = -1;
        for (var i in data) {
          var item = data[i];
          if (i == 'columns')
            continue;

          var frbrfunction = item.frbrfunction;
          if (typeof filteredData[item.frbrfunction] === "undefined") {
            filteredData[item.frbrfunction] = new Array();
          }
          filteredData[item.frbrfunction].push({
            name: parseInt(item.score),
            value: parseInt(item.count)
          });
          if (min == -1 || min > item.score) {
            min = item.score;
          }
          if (max == -1 || max < item.score) {
            max = item.score;
          }
        }

        var bandWidth = (width / (max - min)) - 1;

        var scaleX = d3.scaleLinear()
            .domain([min, max])
            .range([margin.left, width - margin.right])

        for (var frbrfunction in filteredData) {
          var histogram = filteredData[frbrfunction];
          var id = '#bar-chart-' + frbrfunction;

          var scaleY = d3
              .scaleLinear()
              .domain([0, d3.max(histogram, d => d.value)]).nice()
              .range([height - margin.bottom, margin.top])

          d3.select(id )
            .append("g")
            .attr("fill", "steelblue")
            .selectAll("rect")
            .data(histogram)
            .enter().append("rect")
            .attr("x", item => item.name * (bandWidth + 1)) //scaleX.bandwidth();
            .attr("y", item => Math.floor(scaleY(item.value)))
            .attr("height", item => (100 - Math.floor(scaleY(item.value))))
            .attr("width", bandWidth) //scaleX.bandwidth();
            .text(function(d) {
              return d.value;
            });
        }
      });
  }

  function resetTabs() {
    $('#myTabContent .tab-pane').each(function() {
      if (!$(this).attr('id').match(/^marc-/)) {
        $(this).removeClass('active');
      }
    });
  }

  $(document).ready(function () {
    itemsPerPage();

    $('.fa-search').click(function (event) {
      doSearch();
    });
    $('#search').submit(function (event) {
      event.preventDefault();
      doSearch();
    });
    $('#set-facets').click(function (event) {
      event.preventDefault();
      setFacets();
    });

    loadCompleteness();

    $('#myTab a').on('click', function (e) {
      e.preventDefault();
      resetTabs();
      var id = $(this).attr('id');
      if (id == 'data-tab') {
        loadDataTab(buildUrl());
      } else if (id == 'completeness-tab') {
        loadCompleteness();
      } else if (id == 'issues-tab') {
        loadIssues();
      } else if (id == 'functions-tab') {
        loadFunctions();
      } else if (id == 'classifications-tab') {
        loadClassifications();
      } else if (id == 'terms-tab') {
        loadTerms();
      }
      $(this).tab('show');
    });
  });
</script>
</body>
</html>