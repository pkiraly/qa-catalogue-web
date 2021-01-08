{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="authorities" role="tabpanel" aria-labelledby="authorities-tab">
      <h2>Authority analysis</h2>
      <div id="authorities-content">
        {include 'authorities-by-records.tpl'}
        {include 'authorities-histogram.tpl'}
        {include 'authorities-by-field.tpl'}
      </div>
    </div>
  </div>
</div>
{literal}
<script>
    function setAuthoritiesLinkHandlers() {
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
                showTab('terms');
                scroll(0, 0);

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

    $(document).ready(function () {
        setAuthoritiesLinkHandlers();
    }
</script>
{/literal}
{include 'common/html-footer.tpl'}