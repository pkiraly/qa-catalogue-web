<!-- Nav tabs -->
<nav>
  <ul class="nav nav-tabs" id="myTab">
    {if $display['data']}
    <li class="nav-item">
      <a class="nav-link1{if $tab == 'data'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
         id="data-tab" aria-controls="data"
         href="?tab=data{$generalParams}">{_('Data')}</a>
    </li>
    {/if}
    {if $display['completeness']}
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
          <a class="dropdown-item" href="?tab=functions{$generalParams}"> &nbsp; Functional analysis</a>
        </div>
      {elseif $catalogue->getSchemaType() == 'PICA'}
        <a class="nav-link1 {if $tab == 'completeness'}active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="completeness-tab" aria-controls="completeness"
           href="?tab=completeness{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Completeness')}</a>
      {elseif $catalogue->getSchemaType() == 'UNIMARC'}
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
          <a class="dropdown-item" href="?tab=functions{$generalParams}"> &nbsp; Functional analysis</a>
        </div>
      {/if}
    </li>
    {/if}
    {if $display['issues'] || $display['shacl'] || $display['delta']}
    <li class="nav-item1">
      {if $display['shacl'] || $display['delta']}
        <a class="nav-link1 {if $isValidation}active{/if} dropdown-toggle"
           data-toggle="dropdown" role="tab1" aria-selected="true"
           id="validation-tab" aria-controls="validation"
           href="#">{_('Validation')}</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="?tab=issues{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Issues')}</a>
          {if $display['delta']}
            <a class="dropdown-item" href="?tab=delta{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Validation of latest changes')}</a>
          {/if}
          {if $display['shacl']}
            <a class="dropdown-item" href="?tab=shacl{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Custom validation')}</a>
          {/if}
          {if $display['translations']}
            <a class="dropdown-item" href="?tab=translations{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Translation analysis')}</a>
          {/if}
        </div>
      {elseif $display['issues']}
        <a class="nav-link1 {if $tab == 'issues'}active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="issues-tab" aria-controls="issues"
           href="?tab=issues{$generalParams}{if isset($groupId)}&groupId={$groupId}{/if}">{_('Issues')}</a>
      {/if}
    </li>
    {/if}
    {if $display['classifications'] || $display['authorities']}
    <li class="nav-item1">
      <a class="nav-link1 {if $isAuthority}active{/if} dropdown-toggle" data-toggle="dropdown" role="tab1" aria-selected="false"
         id="classifications-tab" aria-controls="classifications"
         href="#">{_('Authorities')}</a>
      <div class="dropdown-menu">
        {if $display['classifications']}
        <a class="dropdown-item" href="?tab=classifications{$generalParams}">{_('Subject analysis')}</a>
        {/if}
        {if $display['authorities']}
        <a class="dropdown-item" href="?tab=authorities{$generalParams}">{_('Authority name analysis')}</a>
        {/if}
      </div>
    </li>
    {/if}
    {if $display['pareto']}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'pareto'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="pareto-tab" aria-controls="pareto"
           href="?tab=pareto{$generalParams}">Pareto</a>
      </li>
    {/if}
    {if $display['history']}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'history'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="history-tab" aria-controls="history"
           href="?tab=history{$generalParams}">{_('History')}</a>
      </li>
    {/if}
    {if $display['timeline']}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'timeline'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="timeline-tab" aria-controls="timeline"
           href="?tab=timeline{$generalParams}">{_('Timeline')}</a>
      </li>
    {/if}
    {if $display['network']}
      <li class="nav-item1">
        <a class="nav-link1{if $tab == 'network'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
           id="network-tab" aria-controls="network"
           href="?tab=network{$generalParams}">{_('Network')}</a>
      </li>
    {/if}
    {if $display['terms'] || $display['data-element-timeline'] || $display['control-fields'] || $display['collocations'] || $display['download'] || $display['settings']}
    <li class="nav-item1">
      <a class="nav-link1 {if $isTool}active{/if} dropdown-toggle" data-toggle="dropdown" role="tab1" aria-selected="false"
         id="terms-tab" aria-controls="terms"
         href="#">{_('Tools')}</a>
      <div class="dropdown-menu">
        {if $display['terms']}
          <a class="dropdown-item" href="?tab=terms{$generalParams}">{_('Terms')}</a>
        {/if}
        {if $display['data-element-timeline']}
          <a class="dropdown-item" href="?tab=data-element-timeline{$generalParams}">{_('Data element timeline')}</a>
        {/if}
        {if $display['control-fields']}
          <a class="dropdown-item" href="?tab=control-fields{$generalParams}">{_('Value distribution in control fields')}</a>
        {/if}
        {if $display['collocations']}
          <a class="dropdown-item" href="?tab=collocations{$generalParams}">{_('Collocations')}</a>
        {/if}
        {if $display['download']}
          <a class="dropdown-item" href="?tab=download{$generalParams}">{_('Download')}</a>
        {/if}
        {if $display['settings']}
          <a class="dropdown-item" href="?tab=settings{$generalParams}">{_('Facets')}</a>
        {/if}
      </div>
    </li>
    {/if}
    {if $display['about']}
    <li class="nav-item1">
      <a class="nav-link1{if $tab == 'about'} active{/if}" data-toggle="tab1" role="tab1" aria-selected="false"
         id="about-tab" aria-controls="about"
         href="?tab=about{$generalParams}">{_('About')}</a>
    </li>
    {/if}
  </ul>
</nav>
