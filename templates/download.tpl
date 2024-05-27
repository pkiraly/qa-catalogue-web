{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="history" role="tabpanel" aria-labelledby="history-tab">
      <h2>{_('Download')}</h2>
      <p class="metric-definition">
        {_('Download the CSV files behind this site')}
      </p>
      <div id="history-content">
        <ul>
          {foreach from=$categories key=label item=files}
            {if $files}
              <li><strong>{_($label)}:</strong>
                {foreach from=$files key=file item=property name=files}
                  <a href="?tab=download&action=download&file={$file}">{$file}</a>
                  <span style="color: #999">{$property['size']}</span>{if !$smarty.foreach.files.last}, {/if}
                {/foreach}
              </li>
            {/if}
          {/foreach}
        </ul>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
