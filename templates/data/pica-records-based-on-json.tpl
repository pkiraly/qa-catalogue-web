{foreach from=$docs item=doc}
  {assign var="record" value=$controller->getRecord($doc)}
  {assign var="id" value=$doc->id|regex_replace:"/ +$/":""}
  {assign var="type" value=$record->getFirstField('type_ss')}
  <div class="record record-pica">
    <h2>
      <i class="fa fa-{$record->type2icon($type)}" title="type: {$type}"></i>
      <strong>{$id}</strong>
      <a href="{$record->opacLink($doc->id)}" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>

    <div class="details" id="details-{$id}">
      <ul class="nav nav-tabs" id="record-views-{$id}">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
             id="pica-human-tab-{$id}" href="#pica-human-{$id}" aria-controls="pica-human-tab">Inhalt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="pica-raw-tab-{$id}" href="#pica-raw-{$id}" aria-controls="pica-raw-tab">PICA+</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="pica-labels-tab-{$id}" href="#pica-labels-{$id}" aria-controls="pica-labels-tab">PICA-Felder</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="pica-solr-tab-{$id}" href="#pica-solr-{$id}" aria-controls="pica-solr-tab">Solr</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="pica-issue-tab-{$id}" href="{$record->issueLink($id)}" aria-controls="pica-issue-tab" data-id="{$id}">{_('Issues')}</a>
        </li>
      </ul>

      <div class="tab-content" id="details-tab-{$id}">
        <div class="tab-pane active" id="pica-human-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/pica/human-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="pica-raw-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/pica/raw-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="pica-labels-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/pica/labels-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="pica-solr-{$id}" role="tabpanel" aria-labelledby="data-tab">
          {include 'data/pica/solr-view.tpl'}
        </div>
        <div class="tab-pane record-tab" id="pica-issue-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <p>Retrieving issues detected in this bibliographic record (if any). It might take for a while.</p>
        </div>
      </div>
    </div>
  </div>
{/foreach}
