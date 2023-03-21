{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
      <h2>Timeline of changes</h2>

      <p>How did the catalogue change over time? There are two types of issues:</p>
      <ul>
        <li>the value clearly breaks a well documented constraint. E.g. if the value of <tt>245$ind1</tt> is a space,
          that is a clear issue, because 245's first indicator is defined in Library of Congress MARC21, as it should
          contains either 0 or 1.</li>
        <li>there is a data element which is not defined in MARC21 or in its known extensions, so we can not judge its
          validity because we do not know its rules.
          E.g. <tt>024$9</tt> - we are not sure if it is an issue, it might be a legal locally defined subfieeld,
          because 9 is reserved for that (however it also might be a typo).
          <tt>250$p</tt> - we are also not sure, but since it is not 9, the probability that it is a legal locally defined subfield
          is much lesser. In both cases it might happen, that the record is imported from somewhere else, and the
          local definition is available in its original organisation, but in the current catalogue it is out of context.
        </li>
      </ul>
      <p><em>all issues</em> covers both types of issues, <em>issues in documented data elements</em> covers only the
        first type.
        <em>change in records</em> represents the difference in the number of "good" records (not having the first issue
        type) between the previous and current measurement.
        <em>change in %</em> represents the difference in the percentage of "good" records (no having the first issue
        type) between the previous and current measurement.
      </p>

      {if !is_null($byCategoryImage)}
        <p><img src="images/{$db}/{$byCategoryImage}" width="1000"/></p>
      {/if}

      {if !empty($byTypeImages)}
        {foreach from=$byTypeImages item=img}
          <p><img src="images/{$db}/{$img}" width="1000"/></p>
        {/foreach}
      {/if}

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
            <th>{_('without')}</th>
            <th>{_('with')}</th>
            <th>{_('without')}</th>
            <th>{_('with')}</th>
            <th title="the difference in the number of 'good' records (not having the first issue
            type) between the previous and current measurement">in records</th>
            <th title="the difference in the percentage of 'good' records (no having the first issue type) between the previous and current measurement">
                in %</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$totals key=version item=issues name=foo}
            <tr>
              <td class="version">
                {if $versioning}
                  <a href="?tab=issues&version={$version}">{$version}</a>
                {else}
                  {$version}
                {/if}
              </td>
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
