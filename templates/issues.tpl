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

  function loadClickMoreHandlers() {
    $('a.clickMore').unbind("click").click(function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      console.log('clickMore ' + url);
      var id = $(this).attr('data-id');
      var page = $(this).attr('data-page');
      $.ajax(url)
        .done(function (result) {
          console.log('clickMore RESULT');
          $('tr.x-' + id).remove();
          $(result).insertAfter('tr.h-' + id);
          $('tr.t-' + id).show();
          $('a.clickMore-' + id).css('font-weight', 'normal');
          $('a.byTag-' + id).css('font-weight', 'normal');
          $('a#clickMore-' + page).css('font-weight', 'bold');
          loadHandlers();
        });
    });
  }

  function loadByPathHandlers() {
    $('a.byPath').unbind("click").click(function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      console.log('byPath ' + url);
      var id = $(this).attr('data-id');
      var page = id + '-0';
      $.ajax(url)
        .done(function (result) {
          console.log('byPath RESULT');
          $('tr.x-' + id).remove();
          $(result).insertAfter('tr.h-' + id);
          $('tr.t-' + id).show();
          $('a.clickMore-' + id).css('font-weight', 'normal');
          $('a.byTag-' + id).css('font-weight', 'normal');
          $('a#clickMore-' + page).css('font-weight', 'bold');
          loadHandlers()
        });
      });
  }

  function loadByTagHandlers() {
    $('a.byTag').unbind("click").click(function (event) {
      event.preventDefault();
      var url = $(this).attr('href');
      console.log('byTag ' + url);
      var id = $(this).attr('data-id');
      $.ajax(url)
        .done(function (result) {
          console.log('byTag RESULT');
          $('tr.x-' + id).remove();
          $(result).insertAfter('tr.h-' + id);
          $('tr.t-' + id).show();
          $('a.clickMore-' + id).css('font-weight', 'normal');
          $('a#byTag-' + id).css('font-weight', 'bold');
          loadHandlers();
        });
    });
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

  function loadHandlers() {
      loadIssueHandlers();
      loadClickMoreHandlers();
      loadByPathHandlers();
      loadByTagHandlers();
  }

  $(document).ready(function () {
    loadHandlers();
  });
{/literal}</script>
{include 'common/html-footer.tpl'}
