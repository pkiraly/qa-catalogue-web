{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="js/handlebars.min.js"></script>
<!-- handlebars.runtime-v4.1.1.js -->
<script id="filter-param-template" type="text/x-handlebars-template">{literal}fq={{field}}:"{{value}}"{/literal}</script>
<script id="filter-all-param-template" type="text/x-handlebars-template">{literal}fq={{field}}:*{/literal}</script>
<script id="list-filters-template" type="text/x-handlebars-template">
{literal}{{#list filters}}<a href="#" data="{{param}}"><i class="fa fa-minus" aria-hidden="true"></i></a> {{label}}{{/list}}{/literal}
</script>

<script id="item-prev-next-template" type="text/x-handlebars-template">{literal}<a href="#" data="{{start}}">{{label}}</a>{/literal}</script>

<script id="strong-template" type="text/x-handlebars-template">
  {literal}<strong>{{item}}</strong>{/literal}
</script>

<script type="text/javascript">{literal}
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

    // DONE
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
            scroll(0, 0);
        });
        $('#prev-next-footer a').click(function (event) {
            event.preventDefault();
            start = $(this).attr('data');
            loadDataTab(buildUrl());
            scroll(0, 0);
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
        $('div.facet-block ul a.facet-up').click(function (event) {
            event.preventDefault();
            var field = $(this).attr('data-field');
            var offset = parseInt($(this).attr('data-offset'));
            facetOffsetParameters[field] = (offset > 10) ? offset - 10 : 0;
            loadFacetNavigation(field);
        });
        $('div.facet-block ul a.facet-down').click(function (event) {
            event.preventDefault();
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
                // $('#numFound').html(result.numFound.toLocaleString('en-US'));
                // $('#solr-url').html(urlParam);
                // createPrevNextLinks(result.numFound);

                $('#records').html(result.records);
                showRecordDetails();
                // $('#facet-list').html(result.facets);
                setFacetClickBehaviour();
                setFacetNavigationClickBehaviour();
                $('#message').html('');
                $('a[aria-controls="marc-issue-tab"]').click(function (e) {
                    var id = $(this).attr('data-id');
                    var url = 'read-record-issues.php?db=' + db + '&id=' + id + '&display=1';
                    $.ajax(url)
                        .done(function(result) {
                            $('#marc-issue-' + id).html(result);
                        });
                });
            })
            .fail(function() {
                console.error("error: can not access " + urlParam);
            });
    }

    function showRecordDetails() {
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

    function searchForField(field) {
        var filterParam = filterAllParamTemplate({'field': field});
        filters = [];
        filters.push({
            'param': filterParam,
            'label': getFacetLabel(field) + ': *'
        });
        start = 0;
        loadDataTab(buildUrl());
        showTab('data');
    }

    function loadCompleteness() {
        $.get('read-packages.php?db=' + db + '&display=1')
            .done(function(data) {
                $('#completeness-group-table').html(data);
            });
        $.get('read-completeness.php?db=' + db + '&display=1')
            .done(function(data) {
                $('#completeness-field-table').html(data);
                setCompletenessLinkHandlers();
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

    function setCompletenessLinkHandlers() {
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
                showTab('terms');
                scroll(0, 0);
                $('#terms-content').html(result.facets);
                $('#terms-scheme').html(scheme);
                $('#terms-scheme').attr('data-facet', facet);
                $('#terms-scheme').attr('data-query', termQuery);

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
                    showTab('data');
                });
            });
        });
    }

    function clearFq(fq) {
        return fq.replace(/_ss:/g, ':').replace(/%22/g, '"').replace(/_/g, ' ').replace(/:/, ': ');
    }

    function resetTabs() {
        $('#myTabContent .tab-pane').each(function() {
            if (!$(this).attr('id').match(/^marc-/)) {
                $(this).removeClass('active');
            }
        });
    }

    function showTab(id) {
        $('#myTabContent .tab-pane').each(function() {
            if ($(this).attr('id') == id) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
        $('#myTab a[href="#' + id + '"]').tab('show');
    }

    function loadLastUpdate() {
        var url = 'read-last-update.php?db=' + db;
        $.getJSON(url, function(result, status) {
            $('#last-update').html(result.lastUpdate);
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

        loadLastUpdate();
        // loadCompleteness();
        $('#myTab a').on('click', function (e) {
           location.href = $(this).attr('href');
        });

        /*
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
            }
            $(this).tab('show');
        });
        */
    });
{/literal}
</script>
{include 'common/html-footer.tpl'}
