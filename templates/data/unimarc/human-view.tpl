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
  {include 'unimarc/327.tpl'}{* CONTENTS NOTE *}
  {include 'unimarc/330.tpl'}{* SUMMARY/ABSTRACT NOTE *}
</table>

{* Host Item Entry *}
{include 'marc/773.tpl'}

{* Electronic Location and Access *}
{include 'unimarc/856.tpl'}

{if $record->hasAuthorityNames('UNIMARC') || $record->hasSubjectHeadings('UNIMARC')}
  <table class="authority-names">
    {if $record->hasAuthorityNames('UNIMARC')}
      <tr><td colspan="2" class="heading">Authority names</td></tr>
      {* TODO: 740, 751, 752, 753, 754, 800, 810, 811, 830 *}
      {include 'unimarc/700.tpl'}{* Personal name - Primary responsibility *}
      {include 'unimarc/701.tpl'}{* Personal name - Alternative responsibility *}
      {include 'unimarc/702.tpl'}{* Personal name - Secondary responsibility *}
      {include 'unimarc/710.tpl'}{* Coprorate body name - Primary responsibility *}
      {include 'unimarc/711.tpl'}{* Coprorate body name - Alternative responsibility *}
      {include 'unimarc/712.tpl'}{* Coprorate body name - Secondary responsibility *}
      {include 'unimarc/730.tpl'}{* Name - entity responsible *}
    {/if}

    {if $record->hasSubjectHeadings('UNIMARC')}
      <tr><td colspan="2" class="heading">Subjects</td></tr>
      {include 'unimarc/600.tpl'}{* Personal names as subjects *}
      {include 'unimarc/601.tpl'}{* Corporate names as subjects *}
      {include 'marc/052.tpl'}{* geographic classification *}
      {include 'marc/072.tpl'}{* subject category code *}
      {include 'marc/080.tpl'}{* UDC *}
      {include 'marc/082.tpl'}{* Dewey Decimal Classification *}
      {include 'marc/083.tpl'}{* Additional Dewey Decimal Classification *}
      {include 'marc/084.tpl'}{* other classifications *}
      {include 'marc/085.tpl'}{* synthesized classifications *}
      {include 'marc/086.tpl'}{* government document classifications *}
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
{include 'unimarc/801.tpl'}

{* This seems to be a MARC21-only approach, and that only for some specific local implementation with the field 912 *}
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
