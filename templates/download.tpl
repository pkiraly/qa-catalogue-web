{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="history" role="tabpanel" aria-labelledby="history-tab">
      <h2>Download</h2>

      <p>Download the CSV files behind this site</p>

      <div id="history-content">
        <ul>
          {foreach from=$categories key=label item=files}
            <li><strong>{$label}:</strong>
              {foreach from=$files key=file item=property name=files}
                <a href="?tab=download&action=download&file={$file}">{$file}</a>
                <span style="color: #999">{$property['size']}</span>{if !$smarty.foreach.files.last}, {/if}
              {/foreach}
            </li>
          {/foreach}
        </ul>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
