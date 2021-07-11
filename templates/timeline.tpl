{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
      <h2>Timeline of changes</h2>

      <p>How did the catalogue change over time?</p>
        <table id="timeline">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th colspan="2">all issues</th>
              <th colspan="2">issues in documented data elements</th>
              <th colspan="2">change</th>
            </tr>
            <tr>
              <th>version</th>
              <th>records</th>
              <th>without</th>
              <th>with</th>
              <th>without</th>
              <th>with</th>
              <th>in records</th>
              <th>in %</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$totals key=version item=issues name=foo}
              <tr>
                <td class="version">{$version}</td>
                <td class="count">{number_format($issues['count'])}</td>
                <td colspan="2">
                  <div><div style="float: left">{sprintf("%.2f", $issues[1]['goodPercent'])}%</div>{sprintf("%.2f", $issues[1]['badPercent'])}%</div>
                  <div class="barchart">
                    <div class="greenchart" style="width: {ceil($issues[1]['goodPercent'] * 3)}px;"> </div>
                  </div>
                  <div><div style="float: left">{number_format($issues[1]['good'])}</div>{number_format($issues[1]['bad'])}</div>
                </td>
                <td colspan="2">
                  <div><div style="float: left">{sprintf("%.2f", $issues[2]['goodPercent'])}%</div>{sprintf("%.2f", $issues[2]['badPercent'])}%
                  <div class="barchart">
                    <div class="greenchart" style="width: {ceil($issues[2]['goodPercent'] * 3)}px;"> </div>
                  </div>
                  <div><div style="float: left">{number_format($issues[2]['good'])}</div>{number_format($issues[2]['bad'])}</div>
                </td>
                <td class="change {if $issues['change']['records'] > 0}change-positive{elseif $issues['change']['records'] < 0}change-negative{/if}">
                  {if $smarty.foreach.foo.index > 0}
                    {if $issues['change']['records'] > 0}+{/if}{number_format($issues['change']['records'])}
                    {if $issues['change']['records'] > 0}
                      <i class="fa fa-arrow-up"></i>
                    {elseif $issues['change']['records'] < 0}
                      <i class="fa fa-arrow-down"></i>
                    {/if}
                  {/if}
                </td>
                <td class="change {if $issues['change']['percent'] > 0}change-positive{elseif $issues['change']['percent'] < 0}change-negative{/if}">
                  {if $smarty.foreach.foo.index > 0}
                    {if $issues['change']['percent'] > 0}+{/if}{sprintf("%.3f", $issues['change']['percent'])}%
                    {if $issues['change']['percent'] > 0}
                      <i class="fa fa-arrow-up"></i>
                    {elseif $issues['change']['percent'] < 0}
                      <i class="fa fa-arrow-down"></i>
                    {/if}
                  {/if}
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
