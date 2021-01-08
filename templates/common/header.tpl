<h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
<p>
  <i class="fa fa-book" aria-hidden="true"></i>
  {if $db == 'szte'}
    <a href="http://www.ek.szte.hu/" target="_blank">A Szegedi Tudományegyetem Klebelsberg Kuno Könyvtára</a>
  {elseif $db == 'mokka'}
    <a href="http://mokka.hu/" target="_blank">mokka &mdash; Magyar Országos Közös Katalógus</a>
  {elseif $db == 'cerl'}
    <a href="https://www.cerl.org/resources/hpb/main/" target="_blank">The Heritage of the Printed Book Database</a>
  {elseif $db == 'dnb'}
    <a href="https://www.dnb.de/" target="_blank">Deutsche Nationalbibliothek</a>
  {elseif $db == 'gent'}
    <a href="https://lib.ugent.be/" target="_blank">Universiteitsbibliotheek Gent</a>
  {elseif $db == 'loc'}
    <a href="https://catalog.loc.gov/" target="_blank">Library of Congress</a>
  {elseif $db == 'mtak'}
    <a href="https://mtak.hu/" target="_blank">Magyar Tudományos Akadémia Könyvtára</a>
  {elseif $db == 'bayern'}
    <a href="https://www.bib-bvb.de/" target="_blank">Verbundkatalog B3Kat des Bibliotheksverbundes Bayern (BVB) und des Kooperativen Bibliotheksverbundes Berlin-Brandenburg (KOBV)</a>
  {elseif $db == 'bnpl'}
    <a href="https://bn.org.pl/" target="_blank">Biblioteka Narodowa (Polish National Library)</a>
  {elseif $db == 'nfi'}
    <a href="https://www.kansalliskirjasto.fi/en" target="_blank">Kansallis Kirjasto/National Biblioteket (The National Library of Finnland)</a>
  {elseif $db == 'gbv'}
    <a href="http://www.gbv.de/" target="_blank">Verbundzentrale des Gemeinsamen Bibliotheksverbundes</a>
  {elseif $db == 'bl'}
    <a href="http://bl.uk/" target="_blank">British Library</a>
  {/if}
  &nbsp; &nbsp; <span class="last-update-info">(last data update: <span id="last-update"></span>)</span>
</p>
