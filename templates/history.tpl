{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="history" role="tabpanel" aria-labelledby="history-tab">
      <h2>{_('History of cataloging')}</h2>

      <p class="metric-definition">
        {_('history_definition')}
      </p>

      {if (count($files) > 0)}
        <p>
          {if ($catalogue->getSchemaType() == 'MARC21')}
            {_('history_definition_marc')}
          {elseif ($catalogue->getSchemaType() == 'PICA')}
            {_('history_definition_pica')}
          {/if}
        </p>

        <p>
          {_('This chart was implemented based on Benjamin Schmidt\'s blog post')}
          <a href="http://creatingdata.us/datasets/marc-history/">The history library catalogs inside MARC records</a>
        </p>

        <div id="history-content">
          {foreach from=$files key=index item=file}
            <p><img src="images/{$id}/{$file}" width="1000"/></p>
          {/foreach}
        </div>
      {else}
        {_('missing-analysis')}
      {/if}
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
