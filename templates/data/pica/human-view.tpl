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
  {include 'pica/005A.tpl'}{* ISSN *}
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
      <tr>
        <td colspan="2" class="heading">Authority names</td>
      </tr>
    {/if}

    {if $record->hasSubjectHeadings()}
      <tr>
        <td colspan="2" class="heading">Subjects</td>
      </tr>
    {/if}
  </table>
{/if}