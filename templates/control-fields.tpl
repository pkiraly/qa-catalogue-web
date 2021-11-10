{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="completeness" role="tabpanel" aria-labelledby="completeness-tab">
      <h2>Value distribution in control fields</h2>

      <table width="100%">
        <tr>
          <td style="border-right: 5px solid lightgray;">
            <svg class="histogram-chart" width="800" height="{($count * 30) + 90}"></svg>
            <script src="js/barchart.js" type="text/javascript"></script>
            <script>
                var db = '{$db}';
                var count = {$count};
                var histogramDataUrl = '?tab=control-fields&action=histogram&field={$selectedField}&position={$selectedPosition}';
                {literal}
                var units = 'data elements';
                var histogramSvgClass = 'histogram-chart';

                var tooltip = d3.select("body")
                    .append("div")
                    .style("opacity", 0)
                    .attr("class", "tooltip")
                    .attr("id", "tooltip")
                displayBarchart(histogramDataUrl, histogramSvgClass);
                {/literal}
            </script>
          </td>
          <td style="padding-left: 50px;">
            {foreach $supportedPositions as $field => $positions}
              <h4>{$field}</h4>
              <ul>
                {foreach $positions as $position}
                  {assign var="label" value=$solrFieldsMap[$field][$position]->label}
                  <li>
                    {if $selectedField == $field && $selectedPosition == $position}
                      <strong>{$position} {$label}</strong>
                    {else}
                      <a href="?tab=control-fields&field={$field}&position={$position}">{$position} {$label}</a>
                    {/if}
                    {*
                    {if $selectedField == $field && $selectedPosition == $position}
                      <ul>
                        {foreach $terms as $term => $count}
                          <li>{if preg_match('/(^\s|\s\s|\s$)/', $term)}"{preg_replace('/\s/', '&nbsp;', $term)}"{else}{$term}{/if} ({$count|number_format})</li>
                        {/foreach}
                      </ul>
                    {/if}
                    *}
                  </li>
                {/foreach}
              </ul>
            {/foreach}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
