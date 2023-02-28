{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="tt-completeness" role="tabpanel" aria-labelledby="tt-completeness-tab">
      <h2>Thompson&mdash;Traill completeness</h2>
      <p>These scores are the implementation of the following paper:</p>

      <blockquote>
        Kelly Thompson and Stacie Traill (2017)
        <em>Implementation of the scoring algorithm described in Leveraging Python to improve ebook
          metadata selection, ingest, and management</em>, Code4Lib Journal, Issue 38, 2017-10-18.
        <a href="http://journal.code4lib.org/articles/12828" target="_blank">http://journal.code4lib.org/articles/12828</a>
      </blockquote>
      <p>Their approach to calculate the quality of ebook records comming from different data sources.</p>
      <div id="tt-completeness-content">
        {include 'tt-completeness/tt-completeness-histogram.tpl'}
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}