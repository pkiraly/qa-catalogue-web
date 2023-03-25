{foreach from=$docs item=doc}
  {assign var="record" value=$controller->getRecord($doc)}
  {assign var="id" value=$doc->id|regex_replace:"/ +$/":""}
  {assign var="type" value=$record->getFirstField('type_ss')}
  <div class="record">
    <h2>
      <i class="fa fa-{$record->type2icon($type)}" title="type: {$type}"></i>
      <strong>{$id}</strong>
      <a href="{$record->opacLink($doc->id)}" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>

    <div class="details" id="details-{$id}">
      <ul class="nav nav-tabs" id="record-views-{$id}">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-human-tab-{$id}" href="#marc-human-{$id}" aria-controls="marc-human-tab">Record</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-raw-tab-{$id}" href="#marc-raw-{$id}" aria-controls="marc-raw-tab">MARC21</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-labels-tab-{$id}" href="#marc-labels-{$id}" aria-controls="marc-labels-tab">for humans</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-leader-tab-{$id}" href="#marc-leader-{$id}" aria-controls="marc-leader-tab">Leader</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-008-tab-{$id}" href="#marc-008-{$id}" aria-controls="marc-008-tab">008</a>
        </li>
        {if !is_null($record->getField('007'))}
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
               id="marc-007-tab-{$id}" href="#marc-007-{$id}" aria-controls="marc-007-tab">007</a>
          </li>
        {/if}
        {if !is_null($record->getField('006'))}
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
               id="marc-006-tab-{$id}" href="#marc-006-{$id}" aria-controls="marc-006-tab">006</a>
          </li>
        {/if}
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-solr-tab-{$id}" href="#marc-solr-{$id}" aria-controls="marc-solr-tab">Solr</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-issue-tab-{$id}" href="{$record->issueLink($id)}" aria-controls="marc-issue-tab" data-id="{$id}">issues</a>
        </li>
      </ul>

      <div class="tab-content" id="details-tab-{$id}">
        <div class="tab-pane active" id="marc-human-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/marc/human-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="marc-raw-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/marc/raw-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="marc-labels-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/marc/labels-view.tpl'}
        </div>
        <div class="tab-pane record-tab marc-leader control-field-explanation" id="marc-leader-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'marc/leader.tpl'}
        </div>
        <div class="tab-pane record-tab marc-008 control-field-explanation" id="marc-008-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'marc/008.tpl'}
        </div>
        {if !is_null($record->getFields('007'))}
          <div class="tab-pane record-tab marc-007 control-field-explanation" id="marc-007-{$id}" role="tabpanel" aria-labelledby="data-tab">
            {include 'marc/007.tpl'}
          </div>
        {/if}
        {if !is_null($record->getFields('006'))}
          <div class="tab-pane record-tab marc-006 control-field-explanation" id="marc-006-{$id}" role="tabpanel" aria-labelledby="data-tab">
            {include 'marc/006.tpl'}
          </div>
        {/if}
        <div class="tab-pane record-tab" id="marc-solr-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/marc/solr-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="marc-issue-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <p>Retrieving issues detected in this MARC record (if any). It might take for a while.</p>
        </div>
      </div>
    </div>
  </div>
{/foreach}