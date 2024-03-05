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
