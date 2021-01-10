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
  }

  $(document).ready(function () {
    loadIssueHandlers()
  });
{/literal}</script>
{include 'common/html-footer.tpl'}
