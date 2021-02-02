{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="about" role="tabpanel" aria-labelledby="about-tab">
      <div id="about-tab">
        <p>
          This experimental website is part of a research project called Measuring Metadata Quality
          conducted by Péter Király. You can read more about the research at
          <a href="https://pkiraly.github.io" target="_blank">pkiraly.github.io</a>.
        </p>

        <p>This is an open source project. You can find the code at:</p>
        <ul>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc" target="_blank">Backend (Java)</a></li>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc-web" target="_blank">Frontend (PHP)</a></li>
        </ul>

        <p><em>Credits</em></p>
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
          I would like to thank the experts I have consulted regarding to subject analysis: Rudolf
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