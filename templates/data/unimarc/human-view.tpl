<table style="width:100%">
  {include 'unimarc/200.tpl'}{* TITLE *}
  {include 'unimarc/205.tpl'}{* EDITION STATEMENT *}
  {include 'unimarc/210.tpl'}{* PUBLICATION *}
  {include 'unimarc/215.tpl'}{* PHYSICAL DESCRIPTION *}
  {include 'unimarc/225.tpl'}{* SERIES *}
  {include 'unimarc/010.tpl'}{* ISBN *}
  {include 'unimarc/021.tpl'}{* LEGAL DEPOSIT NUMBER *}
  {include 'unimarc/675.tpl'}{* UDC *}
  {include 'unimarc/317.tpl'}{* PROVENANCE NOTE *}
</table>
{* include 'marc/773.tpl' *}
{*
{assign var="tag245" value=$record->getField('245')}
{assign var="tag773" value=$record->getField('773')}
{if isset($tag245->subfields->a) || isset($tag245->subfields->b)}
  {include 'data/conditional-foreach.tpl' obj=$tag245->subfields key='a'}
  {include 'data/conditional-foreach.tpl' obj=$tag245->subfields key='b'}
{elseif isset($tag773)}
  {include 'data/conditional-foreach.tpl' obj=$tag773->subfields key='t'}
  {if isset($tag245->subfields->n)}
    {include 'data/conditional-foreach.tpl' obj=$tag245->subfields key='n'}
  {/if}
{/if}
*}
{* 245c_Title_responsibilityStatement_ss *}
{if isset($tag245->subfields->c)}
  {include 'data/conditional-foreach.tpl' obj=$tag245->subfields key='c'
    label='<i class="fa fa-pencil" aria-hidden="true"></i>' suffix='<br/>'}
    {* 773a_PartOf_ss *}
{elseif isset($tag773->subfields->a)}
  {include 'data/conditional-foreach.tpl' obj=$tag773->subfields key='a'
    label='<i class="fa fa-pencil" aria-hidden="true"></i>' suffix='<br/>'}
{/if}

{* 250a_Edition_editionStatement_ss *}
{assign var="fieldInstances" value=$record->getFields('250')}
{if !is_null($fieldInstances)}
  {foreach from=$fieldInstances item=field}
    {if isset($field->subfields->a)}
      <span class="250a_Edition_editionStatement_ss">{$field->subfields->a}</span>
    {/if}
  {/foreach}
  <br/>
{/if}

{if $record->hasPublication()}
    {* 250a_Edition_editionStatement_ss *}
  {assign var="tag260" value=$record->getField('260')}
  <i class="fa fa-calendar" aria-hidden="true"></i>
  Published
  {include 'data/conditional-foreach.tpl' obj=$tag260->subfields key='a' label='in' tag='260a'}{* 260a_Publication_place_ss *}
  {include 'data/conditional-foreach.tpl' obj=$tag260->subfields key='b' label='by' tag='260b'}{* 260b_Publication_agent_ss *}
  {include 'data/conditional-foreach.tpl' obj=$tag260->subfields key='c' label='in' tag='260c'}{* 260c_Publication_date_ss *}
  <br/>
{/if}

{include 'marc/264.tpl'}

{if $record->hasPhysicalDescription()}
  {assign var="tag300" value=$record->getField('300')}
  {* 300a_PhysicalDescription_extent_ss *}
  {include 'data/conditional-foreach.tpl' obj=$tag300->subfields key='a' tag='300a'}
  {* 300c_PhysicalDescription_dimensions_ss *}
  {include 'data/conditional-foreach.tpl' obj=$tag300->subfields key='b' tag='300b'}
  {* 300c_PhysicalDescription_dimensions_ss *}
  {include 'data/conditional-foreach.tpl' obj=$tag300->subfields key='c' tag='300c'}
  <br/>
{/if}

{* Series Statement *}
{include 'marc/490.tpl'}

{* Dates of Publication *}
{include 'marc/362.tpl'}

{* 520a_Summary_ss *}
{assign var="tag520s" value=$record->getFields('520')}
{if !is_null($tag520s)}
  <em>summary:</em> <span class="520">
  {foreach from=$tag520s item=field}
    {include 'data/conditional-foreach.tpl' obj=$field->subfields key='a' suffix='<br/>'}
  {/foreach}
  </span>
{/if}

{* 505a_TableOfContents_ss *}
{assign var="tag505s" value=$record->getFields('505')}
{if !is_null($tag505s)}
  <!-- 505a_TableOfContents_ss -->
  {foreach from=$tag505s item=field}
    {include 'data/conditional-foreach.tpl' obj=$field->subfields key='a' suffix='<br/>'}
  {/foreach}
{/if}

{* Host Item Entry *}
{include 'marc/773.tpl'}

{* Electronic Location and Access *}
{include 'marc/856.tpl'}

{if $record->hasAuthorityNames() || $record->hasSubjectHeadings()}
  <table class="authority-names">
    {if $record->hasAuthorityNames()}
      <tr><td colspan="2" class="heading">Authority names</td></tr>
      {* TODO: 740, 751, 752, 753, 754, 800, 810, 811, 830 *}
      {include 'marc/100.tpl'}{* Main personal names *}
      {include 'marc/110.tpl'}{* Main corporate names *}
      {include 'marc/111.tpl'}{* Main meeting names *}
      {include 'marc/130.tpl'}{* Main meeting names *}
      {include 'marc/700.tpl'}{* Additional personal names *}
      {include 'marc/710.tpl'}{* Additional corporate names *}
      {include 'marc/711.tpl'}{* Additional meeting names *}
      {include 'marc/720.tpl'}{* uncontrolled name *}
      {include 'marc/730.tpl'}{* Additional uniform title *}
      {include 'marc/740.tpl'}{* Additional uniform title *}
    {/if}

    {if $record->hasSubjectHeadings()}
      <tr><td colspan="2" class="heading">Subjects</td></tr>
      {* TODO: 055, 654, 656, 657, 658, 662 *}
      {include 'marc/052.tpl'}{* geographic classification *}
      {include 'marc/072.tpl'}{* subject category code *}
      {include 'marc/080.tpl'}{* UDC *}
      {include 'marc/082.tpl'}{* Dewey Decimal Classification *}
      {include 'marc/083.tpl'}{* Additional Dewey Decimal Classification *}
      {include 'marc/084.tpl'}{* other classifications *}
      {include 'marc/085.tpl'}{* synthesized classifications *}
      {include 'marc/086.tpl'}{* government document classifications *}
      {include 'marc/600.tpl'}{* Personal names as subjects *}
      {include 'marc/610.tpl'}{* Corporate names as subjects *}
      {include 'marc/611.tpl'}{* Meeting names as subjects *}
      {include 'marc/630.tpl'}{* Uniform title as subjects *}
      {include 'marc/647.tpl'}{* named event *}
      {include 'marc/648.tpl'}{* chronological term *}
      {include 'marc/650.tpl'}{* Topics *}
      {include 'marc/651.tpl'}{* Geographic names *}
      {include 'marc/653.tpl'}{* Uncontrolled Index Term *}
      {include 'marc/655.tpl'}{* Genres *}
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
