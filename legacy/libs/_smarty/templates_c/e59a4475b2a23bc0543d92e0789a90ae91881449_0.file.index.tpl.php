<?php
/* Smarty version 3.1.33, created on 2019-11-04 14:44:47
  from '/home/kiru/git/metadata-qa-marc-web/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dc02b4fd5b5f3_61095123',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e59a4475b2a23bc0543d92e0789a90ae91881449' => 
    array (
      0 => '/home/kiru/git/metadata-qa-marc-web/templates/index.tpl',
      1 => 1572875081,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:parts/header.tpl' => 1,
    'file:parts/footer.tpl' => 1,
  ),
),false)) {
function content_5dc02b4fd5b5f3_61095123 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:parts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<body>
<div class="container">
  <!-- Content here -->
  <h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
  <p>
    <i class="fa fa-book" aria-hidden="true"></i>
    <?php echo '<script'; ?>
 type="text/javascript">
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
    <?php echo '</script'; ?>
>
    <?php echo $_smarty_tpl->tpl_vars['gett']->value;?>

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
      <div id="about-tab">
        <p>
          This experimental website is part of a research project called Measuring Metadata Quality
          conducted by Péter Király. You can read more about the research at
          <a href="https://pkiraly.github.io" target="_blank">pkiraly.github.io</a>.
        </p>

        <p>This is an open source project. You can find the code at:</p>
        <ul>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc" target="_blank">Backend (Java)</a></li>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc-web" target="_blank">Frontend (PHP)</a></li>
        </ul>

        <p><em>Credits</em></p>
        <p>Thanks for Johann Rolschewski and Phú for their help in collecting the list of published library catalog,
          Jakob Voß for the Avram specification and for his help in exporting MARC schema to Avram, Carsten Klee
          for the MARCspec. I would like to thank the early users of the software, Patrick Hochstenbach (Gent),
          Osma Suominen and Tuomo Virolainen (FNL), Kokas Károly and Bernátsky László (SZTE), Sören Auer and Berrit
          Genat (TIB), Shelley Doljack, Darsi L Rueda, and Philip E. Schreur (Stanford), Marian Lefferts (CERL),
          Alex Jahnke and Maike Kittelmann (SUB) who provided data, suggestions or other kinds of feedback, Justin
          Christoffersen for language assistance. Special thanks to Reinhold Heuvelmann (DNB) for terminological and
          language suggestions.</p>
        <p>I would like to thank the experts I have consulted regarding to subject analysis: Rudolf Ungváry
          (retired, Hungarian National Library, HU), Gerard Coen (DANS and ISKO-NL, NL), Andreas Ledl (BARTOC and Uni
          Basel, CH), Anna Kasprzik (ZBW, DE), Jakob Voß (GBV, DE), Uma Balakrishnan (GBV, DE),
          Yann Y. Nicolas (ABES, FR), Michael Franke-Maier (Freie Universität Berlin, DE), Gerhard Lauer (Uni Basel, CH).</p>
      </div>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php echo '<script'; ?>
 src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/handlebars.min.js"><?php echo '</script'; ?>
>
<!-- handlebars.runtime-v4.1.1.js -->

<?php echo '<script'; ?>
 id="filter-param-template" type="text/x-handlebars-template">fq={{field}}:"{{value}}"<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 id="filter-all-param-template" type="text/x-handlebars-template">fq={{field}}:*<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 id="list-filters-template" type="text/x-handlebars-template">
  {{#list filters}}<a href="#" data="{{param}}"><i class="fa fa-minus" aria-hidden="true"></i></a> {{label}}{{/list}}
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 id="item-prev-next-template" type="text/x-handlebars-template">
  <a href="#" data="{{start}}">{{label}}</a>
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 id="strong-template" type="text/x-handlebars-template">
    <strong>{{item}}</strong>
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">

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

<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="js/index.js"><?php echo '</script'; ?>
>


<?php $_smarty_tpl->_subTemplateRender('file:parts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
