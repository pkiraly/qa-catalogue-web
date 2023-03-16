{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="about" role="tabpanel" aria-labelledby="about-tab">
      <div id="about-tab">
        <h3>Software</h3>
        <p>
          QA Catalogue is an open source application developed as part of the research project
          <a href="https://pkiraly.github.io" target="_blank">Measuring Metadata Quality</a>
          conducted by Péter Király. The code is available in git repositories for
          <a href="https://github.com/pkiraly/metadata-qa-marc" target="_blank">Backend (Java)</a>
          and <a href="https://github.com/pkiraly/metadata-qa-marc-web" target="_blank">Frontend (PHP)</a>.
          Contributions are welcome!
        </ul>
        <h3>Credits</h3>
        <p>
          Thanks for Johann Rolschewski and Phú for their help in collecting the list of published
          library catalog, Jakob Voß for the Avram specification and for his help in exporting MARC
          schema to Avram, Carsten Klee for the MARCspec, Ákos Takács for Dockerization, Radek
          Svetlik for the Czech MARC data elements. I would like to thank the early users of
          the software, Patrick Hochstenbach (Gent), Osma Suominen and Tuomo Virolainen (FNL),
          Kokas Károly and Bernátsky László (SZTE), Sören Auer and Berrit Genat (TIB), Shelley
          Doljack, Darsi L Rueda, and Philip E. Schreur (Stanford), Marian Lefferts (CERL),
          Alex Jahnke and Maike Kittelmann (SUB) who provided data, suggestions or other kinds of
          feedback, Justin Christoffersen for language assistance. Special thanks to Reinhold
          Heuvelmann (DNB) for terminological and language suggestions.
        </p>
        <p>
          Peter would like to thank the experts consulted regarding to subject analysis: Rudolf
          Ungváry (retired, Hungarian National Library, HU), Gerard Coen (DANS and ISKO-NL, NL),
          Andreas Ledl (BARTOC and Uni Basel, CH), Anna Kasprzik (ZBW, DE), Jakob Voß (GBV, DE),
          Uma Balakrishnan (GBV, DE), Yann Y. Nicolas (ABES, FR), Michael Franke-Maier (Freie
          Universität Berlin, DE), Gerhard Lauer (Uni Basel, CH).
        </p>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
