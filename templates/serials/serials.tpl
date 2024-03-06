{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="serials" role="tabpanel" aria-labelledby="serials-tab">
      <h2>Serials analysis</h2>
      <p>These scores are calculated for each continuing resources (type of record (LDR/6) is
        language material ('a') and bibliographic level (LDR/7) is serial component part ('b'),
        integrating resource ('i') or serial ('s')).</p>
      <p>The calculation is based on a slightly modified version of the method published
        by Jamie Carlstone in the following paper:</p>

      <blockquote>
        Jamie Carlstone (2017) <em>Scoring the Quality of E-Serials MARC Records Using Java</em>,
        Serials Review, 43:3-4, pp. 271-277,
        DOI: <a href="https://doi.org/10.1080/00987913.2017.1350525" target="_blank">10.1080/00987913.2017.1350525</a>
        URL: <a href="https://www.tandfonline.com/doi/full/10.1080/00987913.2017.1350525" target="_blank">https://www.tandfonline.com/doi/full/10.1080/00987913.2017.1350525</a>
      </blockquote>

      <div id="serials-content">
        {include 'serials/serial-histogram.tpl'}
      </div>
    </div>
  </div>
  {include 'common/parameters.tpl'}
</div>
{include 'common/html-footer.tpl'}