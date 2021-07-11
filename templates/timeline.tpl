{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
      <h2>Timeline</h2>
      <div>
        <table id="timeline">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th colspan="2">all issues</th>
              <th colspan="2">issues of documented data types</th>
            </tr>
            <tr>
              <th>version</th>
              <th>records</th>
              <th>good</th>
              <th>bad</th>
              <th>good</th>
              <th>bad</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$totals key=version item=issues}
              <tr>
                <td class="version">{$version}</td>
                <td class="count">{number_format($issues['count'])}</td>
                <td colspan="2">
                  <div><div style="float: left">{sprintf("%.2f", $issues[1]['goodPercent'])}%</div>{sprintf("%.2f", $issues[1]['badPercent'])}%</div>
                  <div class="barchart">
                    <div class="greenchart" style="width: {ceil($issues[1]['goodPercent'] * 4)}px;"> </div>
                  </div>
                  <div><div style="float: left">{number_format($issues[1]['good'])}</div>{number_format($issues[1]['bad'])}</div>
                </td>
                <td colspan="2">
                  <div><div style="float: left">{sprintf("%.2f", $issues[2]['goodPercent'])}%</div>{sprintf("%.2f", $issues[2]['badPercent'])}%
                  <div class="barchart">
                    <div class="greenchart" style="width: {ceil($issues[2]['goodPercent'] * 4)}px;"> </div>
                  </div>
                  <div><div style="float: left">{number_format($issues[2]['good'])}</div>{number_format($issues[2]['bad'])}</div>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
