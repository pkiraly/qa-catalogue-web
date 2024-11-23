{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="pareto" role="tabpanel" aria-labelledby="pareto-tab">
      <h2>Field frequency distribution</h2>

      <p>These charts show how the field frequency patterns. Each chart shows a line which is the function of
        field frequency: on the x axis you can see the subfields ordered by the frequency (how many time a given
        subfield occured in the whole catalogue). They are ordered by frequency from the most frequent top 1%
        to the least frequent 1% subfields.
        The Y axis represents the cumulative occurrence (from 0% to 100%).
      </p>

      <div id="pareto-content">
        {foreach from=$files key=index item=file}
          {if $controller->isDockerized()}
            <p><img src="{$file}" width="1000"/></p>
          {else}
            <p><img src="images/{$id}/{$file}" width="1000"/></p>
          {/if}
        {/foreach}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}