<!-- Nav tabs -->
<nav>
  <ul class="nav nav-tabs" id="myTab">
    <li class="nav-item">
      <a class="nav-link1{if $tab == 'data'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
         id="data-tab" aria-controls="data"
         href="?tab=data{$generalParams}">{_('Data')}</a>
    </li>
    <li class="nav-item">
      {if $catalogue->getSchemaType() == 'MARC21'}
        <a class="nav-link1 {if $isCompleteness}active{/if} dropdown-toggle"
           data-toggle="dropdown" role="tab1" aria-selected="true"
           id="completeness-tab" aria-controls="completeness"
           href="#">{_('Completeness')}</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="?tab=completeness{$generalParams}">{_('Completeness')}</a>
          <div class="dropdown-divider"></div>
          <div style="padding: .25rem 1.5rem; color: #999999"><em>Weighted completeness versions</em></div>
          <a class="dropdown-item" href="?tab=serials{$generalParams}"> &nbsp; Carlstone's serials analysis</a>
          <a class="dropdown-item" href="?tab=tt-completeness{$generalParams}"> &nbsp; Thompson—Traill's e-book completeness</a>
          <a class="dropdown-item" href="?tab=shelf-ready-completeness{$generalParams}"> &nbsp; Booth's shelf-ready completeness</a>
        </div>
      {elseif $catalogue->getSchemaType() == 'PICA'}
        <a class="nav-link1 {if $tab == 'completeness'}active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="completeness-tab" aria-controls="completeness"
           href="?tab=completeness{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Completeness')}</a>
      {/if}
    </li>
    <li class="nav-item1">
      <a class="nav-link1 {if $tab == 'issues'}active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
         id="issues-tab" aria-controls="issues"
         href="?tab=issues{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Issues')}</a>
    </li>
    {if $catalogue->getSchemaType() == 'MARC21'}
      <li class="nav-item1">
        <a class="nav-link1 {if $tab == 'functions'}active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="functions-tab" aria-controls="functions"
           href="?tab=functions{$generalParams}">Functions</a>
      </li>
    {/if}
    <li class="nav-item1">
      <a class="nav-link1 {if $isAuthority}active{/if} dropdown-toggle" data-toggle="dropdown" role="tab1" aria-selected="false"
         id="classifications-tab" aria-controls="classifications"
         href="#">{_('Authorities')}</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="?tab=classifications{$generalParams}">{_('Subject analysis')}</a>
        <a class="dropdown-item" href="?tab=authorities{$generalParams}">{_('Authority name analysis')}</a>
      </div>
    </li>
    {if $catalogue->getSchemaType() == 'MARC21'}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'pareto'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="pareto-tab" aria-controls="pareto"
           href="?tab=pareto{$generalParams}">Pareto</a>
      </li>
    {/if}
    <li class="nav-item1">
      <a class="nav-link1{if $tab == 'history'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
         id="history-tab" aria-controls="history"
         href="?tab=history{$generalParams}">{_('History')}</a>
    </li>
    {if !is_null($historicalDataDir)}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'timeline'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="timeline-tab" aria-controls="timeline"
           href="?tab=timeline{$generalParams}">{_('Timeline')}</a>
      </li>
    {/if}
    {if $displayNetwork}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'network'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="network-tab" aria-controls="network"
           href="?tab=network{$generalParams}">{_('Network')}</a>
      </li>
    {/if}
    <li class="nav-item1">
      <a class="nav-link1 {if $isTool}active{/if} dropdown-toggle" data-toggle="dropdown" role="tab1" aria-selected="false"
         id="terms-tab" aria-controls="terms"
         href="#">{_('Tools')}</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="?tab=terms{$generalParams}">{_('Terms')}</a>
        {if $catalogue->getSchemaType() == 'MARC21'}
          <a class="dropdown-item" href="?tab=control-fields{$generalParams}">{_('Value distribution in control fields')}</a>
        {/if}
        <a class="dropdown-item" href="?tab=collocations{$generalParams}">{_('Collocations')}</a>
        <a class="dropdown-item" href="?tab=download{$generalParams}">{_('Download')}</a>
        <a class="dropdown-item" href="?tab=settings{$generalParams}">{_('Facets')}</a>
      </div>
    </li>
    <li class="nav-item1">
      <a class="nav-link1{if $tab == 'about'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
         id="about-tab" aria-controls="about"
         href="?tab=about{$generalParams}">{_('About')}</a>
    </li>
  </ul>
</nav>
