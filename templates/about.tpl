{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="about" role="tabpanel" aria-labelledby="about-tab">
      <div id="about-tab">
        {assign var=file value="$templates/about.$lang.tpl"}
        {if file_exists($file)}{include $file}{/if}

        <h3>{_('Software')}</h3>
        <p>
          {_t('software_text', 'https://pkiraly.github.io', 'https://github.com/pkiraly/qa-catalogue', 'https://github.com/pkiraly/qa-catalogue-web')}
        </ul>

        <h3>{_('Acknowledgement')}</h3>
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
          Peter would like to thank the experts consulted regarding subject analysis: Rudolf
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
