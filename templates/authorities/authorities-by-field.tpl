<h3>{_('Authority schemes')}</h3>

<table id="authorities-by-field">
  <thead>
    <tr>
      <th class="location">{_('Location')}</th>
      <th class="scheme">{_('Classification/subject headings scheme')}</th>
      <th class="instances">{_('Instances')}</th>
      <th class="records">{_('Records')}</th>
      <th class="chart"></th>
      <th class="chart">%</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$fieldHierarchy key=name item=category}
      <tr class="category">
        <td colspan="2"><h4><i class="fa {$category->icon}" aria-hidden="true" title="{$name}" style="color: black"></i> {$name}</h4></td>
        <td title="instances" class="text-right">{$category->instancecount|number_format}</td>
        <td title="records" class="text-right">{$category->recordcount|number_format}</td>
        <td class="chart"><div style="width: {ceil($category->ratio * 200)}px;">&nbsp;</div></td>
        <td class="text-right" title="{$category->percent|number_format:8}%">{$category->percent|number_format:2}%</td>
      </tr>
      {foreach from=$category->fields key=field item=fieldObj}
        {if isset($recordsByField[$field]) && count($recordsByField[$field]) > 0}
          <tr>
            <td colspan="6"><h5>{if isset($fieldObj->pica3)}{$fieldObj->pica3}{else}{$field}{/if} &mdash; {$fieldObj->name}</h5></td>
          </tr>
          {foreach from=$recordsByField[$field] item=record}
            <tr>
              <td>{$record->location}</td>
              <td>
                {if (isset($record->facet2))}
                  {if $record->facet2exists}
                    <a href="{$controller->termLink($record->facet2, '*:*', $record->scheme)}" class="term-link facet2">{$record->scheme}</a>
                  {else}
                    {$record->scheme}
                  {/if}
                {elseif (isset($record->facet) && isset($record->q))}
                  <a href="{$controller->termLink($record->facet, $record->q, $record->scheme)}">{$record->scheme}</a>
                {else}
                  {if $record->scheme == 'undetectable'}not specified{else}{$record->scheme}{/if}
                {/if}
                <i class="fa fa-chevron-down"  data-id="authority-subfields-{$record->id}" aria-hidden="true" title="show subfields"></i>
              </td>
              <td title="instances" class="text-right">{$record->instancecount|number_format}</td>
              <td title="records" class="text-right">{$record->recordcount|number_format}</td>
              <td class="chart"><div style="width: {ceil($record->ratio * 200)}px;">&nbsp;</div></td>
              <td class="text-right" title="{$record->percent|number_format:8}%">{$record->percent|number_format:2}%</td>
            </tr>
            <tr>
              <td colspan="6" id="authority-subfields-{$record->id}" class="authority-subfields">
                {if $hasSubfields && isset($record->id) && isset($subfields[$record->id])}
                  <p>{_('Which subfields are available in the individual instances of this field?')}</p>
                  <table class="matrix">
                    {foreach from=$matrices[$record->id]['codes'] key=code item=divs}
                      {assign var="total" value=0}
                      {assign var="key" value="{$record->field}{$code}"}
                      {assign var=MAX_WIDTH value=500 - count($divs)}
                      <tr>
                        <td class="labels">
                          <a href="{$controller->completenessLink($key)}" class="completeness" data-field="{$key}">{$code}</a>
                          {if isset($elements[$key]) && $elements[$key] != ''}
                            <span title="{$elements[$key]}">{$elements[$key]}</span>
                          {elseif $code == '$9'}
                            &mdash; <span>({_('locally defined subfield')}</span>
                          {else}
                            &mdash; <span>({_('not defined')})</span>
                          {/if}
                        </td>
                        <td class="bars">
                          {foreach from=$divs item=div name=divs}
                            {assign var=width value=ceil($matrices[$record->id]['widths'][$smarty.foreach.divs.index]['perc'] * $MAX_WIDTH)}
                            {assign var=color value=($div > 0) ? 'green' : 'white'}
                            <span style="width: {$width}px" class="{$color}">&nbsp;</span>
                            {$total = $total + $div}
                          {/foreach}
                        </td>
                        <td class="total">{$total|number_format}</td>
                      </tr>
                    {/foreach}
                  </table>

                  <table class="subfields">
                    <thead>
                      <tr>
                        <th>{_('subfields')}</th>
                        <th class="count">{_('count')}</th>
                      </tr>
                    </thead>
                    <tbody>
                      {foreach from=$subfields[$record->id]['list'] item=item}
                        <tr>
                          <td class="subfields">
                            {foreach from=$item->subfields item=subfield name=subfields}
                              {assign var="sub" value={substr($subfield, 0, 2)}}
                              <a href="{$controller->completenessLink($record->field|cat:$sub)}" class="completeness" data-field="{$record->field}{$sub}"
                              >{$subfield}</a>{if !$smarty.foreach.subfields.last}, {/if}
                            {/foreach}
                          </td>
                          <td class="count">{$item->count|number_format}</td>
                        </tr>
                      {/foreach}
                    </tbody>
                  </table>

                  {if $subfields[$record->id]['has-plus'] || $subfields[$record->id]['has-space']}
                    <p>{_('notes')}:</p>
                    <ul>
                      {if $subfields[$record->id]['has-plus']}
                        <li>{_('+ sign denotes multiple instances')}</li>
                      {/if}
                      {if $subfields[$record->id]['has-space']}
                        <li>{_('_ sign denotes space character')}</li>
                      {/if}
                    </ul>
                  {/if}
                {/if}
              </td>
            </tr>
          {/foreach}
        {/if}
      {/foreach}
    {/foreach}
  </tbody>
</table>


<script>
// $()
$('table#authorities-by-field i').click(function (event) {
  event.preventDefault();
  var id = '#' + $(this).attr('data-id');
  $(id).toggle();
  var up = 'fa-chevron-up';
  var down = 'fa-chevron-down';
  if ($(this).hasClass(down)) {
    $(this).removeClass(down);
    $(this).addClass(up);
  } else {
    $(this).removeClass(up);
    $(this).addClass(down);
  }
});
$('a.completeness').click(function () {
  showTab('completeness');
  setCompletenessLinkHandlers();
});
</script>
