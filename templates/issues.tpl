{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="issues" role="tabpanel" aria-labelledby="issues-tab">
      <h2>Issues in MARC21 records</h2>
      <div id="issues-table-placeholder">
        {include 'issue-summary.tpl'}
      </div>
    </div>
  </div>
</div>
<script type="application/javascript">{literal}
  function openType(t) {
    $('tr.t-' + t).toggle();
  }

  function loadIssueHandlers() {
    $('#issues-table-placeholder tr.t td.count a.search').hover(
      function () {
        $(this).attr('title', 'show records having this issue (max 10 records)');
      },
      function () {
        $(this).find("span:last").remove();
      }
    );

    $('#issues-table-placeholder tr.t td.count a.list').hover(
      function () {
        $(this).attr('title', 'download record IDs having this issue');
      },
    );

    $('#issues-table-placeholder tr.t td.count a.search').on('click', function (e) {
      var query = {'db': db};
      query.errorId = $(this).attr('data-id');
      var issueDetailsUrl = 'read-issue-collector.php'
      $.get(issueDetailsUrl, query)
        .done(function (data) {
          var query = 'id:("' + data.recordIds.join('" OR "') + '")';
          $('#query').val(query);
          showTab('data');
          doSearch();
        });
    });

    $('#issues-table-placeholder tr.t td.count a.list').on('click', function (e) {
      var issueDetailsUrl = 'read-issue-collector.php?'
        + 'db=' + db
        + '&errorId=' + $(this).attr('data-id')
        + '&action=download'
        ;
      window.location=issueDetailsUrl;
    });
  }

  $(document).ready(function () {
    loadIssueHandlers()
  });
{/literal}</script>
{include 'common/html-footer.tpl'}
