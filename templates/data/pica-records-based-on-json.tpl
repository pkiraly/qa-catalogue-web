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
             id="marc-record-tab-{$id}" href="#marc-record-{$id}" aria-controls="marc-record-tab">Record</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-raw-tab-{$id}" href="#marc-raw-{$id}" aria-controls="marc-raw-tab">PICA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-human-tab-{$id}" href="#marc-human-{$id}" aria-controls="marc-human-tab">for humans</a>
        </li>
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
        <div class="tab-pane active" id="marc-record-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <table style="width:100%">
            {include 'pica/titel.tpl'}
            {include 'pica/028A.tpl'}{* Autorin/Autor *}
            {include 'pica/028C.tpl'}{* Beteiligt *}
            {include 'pica/029F.tpl'}{* Körperschaft *}
            {include 'pica/032@.tpl'}{* Ausgabe *}
            {include 'pica/033A.tpl'}{* Erschienen *}
            {include 'pica/034D.tpl'}{* Umfang *}
            {include 'pica/010@.tpl'}{* Sprache(n) *}
            {include 'pica/037A.tpl'}{* Anmerkung *}
            {include 'pica/022A.tpl'}{* Einheitssachtitel *}
            {include 'pica/004A.tpl'}{* ISBN *}
            {include 'pica/006G.tpl'}{* DNB-Nr. *}
            {include 'pica/006U.tpl'}{* WV-Nr. *}
            {include 'pica/036E.tpl'}{* Schriftenreihe *}
            {include 'pica/003O.tpl'}{* Sonstige Nummern *}
            {include 'pica/013D.tpl'}{* Art und Inhalt *}
            {include 'pica/045Q.tpl'}{* Sachgebiete *}
            {include 'pica/044K.tpl'}{* Schlagwortfolge *}
          </table>

          {if $record->hasAuthorityNames() || $record->hasSubjectHeadings()}
            <table class="authority-names">
              {if $record->hasAuthorityNames()}
                <tr><td colspan="2" class="heading">Authority names</td></tr>
              {/if}

              {if $record->hasSubjectHeadings()}
                <tr><td colspan="2" class="heading">Subjects</td></tr>
              {/if}
            </table>
          {/if}

        </div>
        <div class="tab-pane record-tab" id="marc-raw-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <div class="marc-details" id="marc-details-{$id}">
            {if isset($doc->record_sni)}
              <table>
                {foreach from=$record->getMarcFields('PICA') item=row}
                  <tr>
                    {foreach from=$row item=cell}
                      {if is_object($cell)}
                        <td><a href="{$cell->url}" target="_blank">{$cell->text}</a></td>
                      {else}
                        <td>{$cell}</td>
                      {/if}
                    {/foreach}
                  </tr>
                {/foreach}
              </table>
            {/if}
          </div>
        </div>
        <div class="tab-pane record-tab" id="marc-human-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <div class="marc-human" id="marc-human-{$id}">
            {if isset($doc->record_sni)}
              <table>
                {foreach from=$record->resolvePicaFields() item=row}
                  <tr {if !empty($row[0])}class="tag"{/if}>
                    {foreach from=$row item=cell}
                      {if is_object($cell)}
                        {if isset($cell->url)}
                          <td><a href="{$cell->url}" target="_blank">{$cell->text}</a></td>
                        {else}
                          <td colspan="{$cell->span}" class="tag-title"><em>{$cell->text}</em></td>
                        {/if}
                      {else}
                        <td>{$cell}</td>
                      {/if}
                   {/foreach}
                  </tr>
                {/foreach}
              </table>
            {/if}
          </div>
        </div>
        <div class="tab-pane record-tab" id="marc-solr-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <h4>Representation in Solr index</h4>

          <ul>
            {foreach from=$record->getAllSolrFields() item=field}
              <li>
                <span class="label">{$field->label}:</span>
                {foreach from=$field->value item=value name=values}
                  {$value}{if !$smarty.foreach.values.last} &mdash; {/if}
                {/foreach}
              </li>
            {/foreach}
          </ul>
        </div>
        <div class="tab-pane record-tab" id="marc-issue-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <p>Retrieving issues detected in this MARC record (if any). It might take for a while.</p>
        </div>
      </div>
    </div>
  </div>
{/foreach}