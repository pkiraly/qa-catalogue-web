<h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
<p>
  <i class="fa fa-book" aria-hidden="true"></i>
  <script type="text/javascript">
      var cat = db;
      if (db == 'metadata-qa' && typeof catalogue !== "undefined")
          cat = catalogue;

      if (cat == 'szte') {
          document.write('<a href="http://www.ek.szte.hu/" target="_blank">A Szegedi Tudományegyetem Klebelsberg Kuno Könyvtára</a>');
      } else if (cat == 'mokka') {
          document.write('<a href="http://mokka.hu/" target="_blank">mokka &mdash; Magyar Országos Közös Katalógus</a>');
      } else if (cat == 'cerl') {
          document.write('<a href="https://www.cerl.org/resources/hpb/main/" target="_blank">The Heritage of the Printed Book Database</a>');
      } else if (cat == 'dnb') {
          document.write('<a href="https://www.dnb.de/" target="_blank">Deutsche Nationalbibliothek</a>');
      } else if (cat == 'gent') {
          document.write('<a href="https://lib.ugent.be/" target="_blank">Universiteitsbibliotheek Gent</a>');
      } else if (cat == 'loc') {
          document.write('<a href="https://catalog.loc.gov/" target="_blank">Library of Congress</a>');
      } else if (cat == 'mtak') {
          document.write('<a href="https://mtak.hu/" target="_blank">Magyar Tudományos Akadémia Könyvtára</a>');
      } else if (cat == 'bayern') {
          document.write('<a href="https://www.bib-bvb.de/" target="_blank">Verbundkatalog B3Kat des Bibliotheksverbundes Bayern (BVB) und des Kooperativen Bibliotheksverbundes Berlin-Brandenburg (KOBV)</a>');
      } else if (cat == 'bnpl') {
          document.write('<a href="https://bn.org.pl/" target="_blank">Biblioteka Narodowa (Polish National Library)</a>');
      } else if (cat == 'nfi') {
          document.write('<a href="https://www.kansalliskirjasto.fi/en" target="_blank">Kansallis Kirjasto/National Biblioteket (The National Library of Finnland)</a>');
      } else if (cat == 'gbv') {
          document.write('<a href="http://www.gbv.de/" target="_blank">Verbundzentrale des Gemeinsamen Bibliotheksverbundes</a>');
      } else if (cat == 'bl') {
          document.write('<a href="http://bl.uk/" target="_blank">British Library</a>');
      }
  </script>
  &nbsp; &nbsp; <span class="last-update-info">(last data update: <span id="last-update"></span>)</span>
</p>
