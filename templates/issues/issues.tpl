{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="issues" role="tabpanel" aria-labelledby="issues-tab">
      {if $delta}
        <h2>{_('Validation of latest changes')}</h2>
      {else}
        <h2>{_('Violations of record format specification')}</h2>
      {/if}

      <p class="metric-definition">
        {_t('issues_definition')}
        {if $catalogue->getSchemaType() == 'PICA'}
          ({_('Download schema file')}: <a href="?tab=download&action=download&file={$schemaFile}">{$schemaFile}</a>.)
        {/if}
      </p>

      {include 'common/group-selector.tpl'}

      {if isset($versions) && !empty($versions)}
        <p>versions:
          {foreach from=$versions item=currentVersion name="versions"}
            {if $version != $currentVersion}
              <a href="?tab=issues&version={$currentVersion}{$generalParams}">{$currentVersion}</a>
            {else}
              {$currentVersion}
            {/if}
            {if !$smarty.foreach.versions.last}·{/if}
          {/foreach}
        </p>
      {/if}

      {if $delta}
        <p><span style="color: #999999">number of new/updated reords:</span> {$deltaCount}</p>
      {/if}

      <div id="issues-table-placeholder">
        {include 'issues/issue-summary.tpl'}
      </div>
    </div>
  </div>
  {include 'common/parameters.tpl'}
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
          $('tr.t-' + id).remove();
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
          $('tr.t-' + id).remove();
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
          $('tr.t-' + id).remove();
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
