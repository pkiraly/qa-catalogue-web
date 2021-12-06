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
                var histogramDataUrl = '?tab=control-fields&action=histogram&field={$selectedField}&type={$selectedType}&position={$selectedPosition}';
                var solrField = '{$solrField}';
                {literal}
                var units = 'data elements';
                var histogramSvgClass = 'histogram-chart';

                var tooltip = d3.select("body")
                    .append("div")
                    .style("opacity", 0)
                    .attr("class", "tooltip")
                    .attr("id", "tooltip")
                displayBarchart(histogramDataUrl, histogramSvgClass, solrField);
                {/literal}
            </script>
          </td>
          <td style="padding-left: 50px;">
            {foreach $solrFieldsMap as $field => $properties}
              <h4>{$field}</h4>
              {if $field == 'Leader'}
                <ul>
                  {foreach $properties as $position => $positionProperties}
                    <li>
                      {if $selectedField == $field && $selectedPosition == $position}
                        <strong>{$position} {$positionProperties->label}</strong>
                      {else}
                        <a href="?tab=control-fields&field={$field}&position={$position}">{$position} {$positionProperties->label}</a>
                      {/if}
                    </li>
                  {/foreach}
                </ul>
              {else}
                {foreach $properties as $type => $typeProperties}
                  <h5>{$type}</h5>
                  <ul>
                    {foreach $typeProperties as $position => $positionProperties}
                      <li>
                        {if $selectedField == $field && $selectedPosition == $position}
                          <strong>{$position} {$positionProperties->label}</strong>
                        {else}
                          <a href="?tab=control-fields&field={$field}&type={$type}&position={$position}">{$position} {$positionProperties->label}</a>
                        {/if}
                      </li>
                    {/foreach}
                  </ul>
                {/foreach}
              {/if}
            {/foreach}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
