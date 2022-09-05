{foreach from=$docs item=doc}
  {assign var="record" value=$controller->getRecord($doc)}
  {assign var="id" value=$doc->id|regex_replace:"/ +$/":""}
  {assign var="type" value=$record->getFirstField('type_ss')}
  <div class="record">
    <h2>
      <i class="fa fa-{$record->type2icon($type)}" title="type: {$type}"></i>
      <strong>{$id}</strong>
      <a href="#" class="record-details" data="details-{$id}" title="display details"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
      <a href="{$record->opacLink($doc->id)}" target="_blank" title="Display record in the library catalogue"><i class="fa fa-external-link" aria-hidden="true"></i></a>
    </h2>
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
        {* TODO: 740, 751, 752, 753, 754, 800, 810, 811, 830 *}
        {* Main personal names *}
        {include 'marc/100.tpl'}
        {* Main corporate names *}
        {include 'marc/110.tpl'}
        {* Main meeting names *}
        {include 'marc/111.tpl'}
        {* Main meeting names *}
        {include 'marc/130.tpl'}
        {* Additional personal names *}
        {include 'marc/700.tpl'}
        {* Additional corporate names *}
        {include 'marc/710.tpl'}
        {* Additional meeting names *}
        {include 'marc/711.tpl'}
        {* uncontrolled name *}
        {include 'marc/720.tpl'}
        {* Additional uniform title *}
        {include 'marc/730.tpl'}
      {/if}

      {if $record->hasSubjectHeadings()}
        <tr><td colspan="2" class="heading">Subjects</td></tr>
        {* TODO: 055, 654, 656, 657, 658, 662 *}
        {* geographic classification *}
        {include 'marc/052.tpl'}
        {* subject category code *}
        {include 'marc/072.tpl'}
        {* UDC *}
        {include 'marc/080.tpl'}
        {* Dewey Decimal Classification *}
        {include 'marc/082.tpl'}
        {* Additional Dewey Decimal Classification *}
        {include 'marc/083.tpl'}
        {* other classifications *}
        {include 'marc/084.tpl'}
        {* synthesized classifications *}
        {include 'marc/085.tpl'}
        {* government document classifications *}
        {include 'marc/086.tpl'}
        {* Personal names as subjects *}
        {include 'marc/600.tpl'}
        {* Corporate names as subjects *}
        {include 'marc/610.tpl'}
        {* Meeting names as subjects *}
        {include 'marc/611.tpl'}
        {* Uniform title as subjects *}
        {include 'marc/630.tpl'}
        {* named event *}
        {include 'marc/647.tpl'}
        {* chronological term *}
        {include 'marc/648.tpl'}
        {* Topics *}
        {include 'marc/650.tpl'}
        {* Geographic names *}
        {include 'marc/651.tpl'}
        {* Uncontrolled Index Term *}
        {include 'marc/653.tpl'}
        {* Genres *}
        {include 'marc/655.tpl'}
      {/if}
      </table>
    {/if}

    {* Cataloging Source *}
    {include 'marc/040.tpl'}

    {if $record->hasSimilarBooks()}
      <div class="similarity">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search for similar items:
        {if isset($doc->{'9129_WorkIdentifier_ss'})}
          works:
          <a href="{$record->filter('9129_WorkIdentifier_ss', $doc->{'9129_WorkIdentifier_ss'})}" class="record-link">{$doc->{'9129_WorkIdentifier_ss'}}</a>
        {/if}
        {if isset($doc->{'9119_ManifestationIdentifier_ss'})}
          manifestations:
          <a href="{$record->filter('9119_ManifestationIdentifier_ss', $doc->{'9119_ManifestationIdentifier_ss'})}" class="record-link">{$doc->{'9119_ManifestationIdentifier_ss'}}</a>
        {/if}
      </div>
    {/if}

    <div class="details" id="details-{$id}">
      <ul class="nav nav-tabs" id="record-views-{$id}">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-raw-tab-{$id}" href="#marc-raw-{$id}"
             aria-controls="marc-raw-tab">PICA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true"
             id="marc-human-tab-{$id}" href="#marc-human-{$id}"
             aria-controls="marc-human-tab">for humans</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-solr-tab-{$id}" href="#marc-solr-{$id}"
             aria-controls="marc-solr-tab">Solr</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
             id="marc-issue-tab-{$id}" href="{$record->issueLink($id)}"
             aria-controls="marc-issue-tab" data-id="{$id}">issues</a>
        </li>
      </ul>

      <div class="tab-content" id="details-tab-{$id}">
        <div class="tab-pane active record-tab" id="marc-raw-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <div class="marc-details" id="marc-details-{$id}">
            {if isset($doc->record_sni)}
              <table>
                {foreach from=$record->getMarcFields('PICA') item=row}
                  <tr>
                    {foreach from=$row item=cell}
                      <td>{$cell}</td>
                    {/foreach}
                  </tr>
                {/foreach}
              </table>
            {/if}
          </div>
        </div>
        <div class="tab-pane active record-tab" id="marc-human-{$id}" role="tabpanel" aria-labelledby="data-tab">
          <div class="marc-human" id="marc-human-{$id}">
            {if isset($doc->record_sni)}
              <table>
                {foreach from=$record->resolvePicaFields() item=row}
                  <tr {if !empty($row[0])}class="tag"{/if}>
                    {foreach from=$row item=cell}
                      {if gettype($cell) == 'array'}
                        <td colspan="{$cell[1]}" class="tag-title"><em>{$cell[0]}</em></td>
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