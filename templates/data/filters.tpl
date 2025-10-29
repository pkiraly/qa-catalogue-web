{if count($filters) > 0}
  <h3>{_('Filters')}</h3>
  <div id="filter-list">
    <ul>
      {foreach from=$filters item=filter}
        <li>
          <a href="?{$filter->removeLink->url}" title="{_('remove it from the query')}"><i class="fa fa-minus" aria-hidden="true"></i></a>
          {$filter->negation} {$filter->marcCode}: {$filter->removeLink->text}
          <a href="?{$filter->negateLink->url}" title="{_('negate this filter')}"><i class="fa fa-regular fa-eye-slash" aria-hidden="true"></i></a>
          <a href="?{$filter->changeQuery->url}" title="{_('make it the main query')}"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
          <a href="?{$filter->termsLink}" title="{_('check other terms of this field')}"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
        </li>
      {/foreach}
    </ul>
  </div>
{/if}
