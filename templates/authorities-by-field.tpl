<h3>Authority schemes</h3>

<table id="classification">
  <thead>
    <tr>
      <th class="location">Location</th>
      <th class="scheme">Classification/subject headings scheme</th>
      <th class="instances">Instances</th>
      <th class="records">Records</th>
    </tr>
  </thead>
  <tbody>
    {assign var=previous value=""}
    {foreach $records as $record}
      {if $previous != $record->id}
        <tr>
          <td colspan="4"><h4>{$record->field} &mdash; {$fields[$record->field]}</h4></td>
        </tr>
      {/if}
      <tr>
        <td>{$record->location}</td>
        <td>
          {if (isset($record->facet2))}
            {if $record->facet2exists}
              <a href="#" class="term-link facet2" data-facet="{$record->facet2}" data-query="*:*" data-scheme="{$record->scheme}">{$record->scheme}</a>
            {else}
              {$record->scheme}
            {/if}
          {elseif (isset($record->facet) && isset($record->q))}
            <a href="#" class="term-link facet" data-facet="{$record->facet}"
               data-query="{$record->q}" data-scheme="{$record->scheme}">{$record->scheme}</a>
          {else}
            {if $record->scheme == 'undetectable'}not specified{else}{$record->scheme}{/if}
          {/if}
          <i class="fa fa-chevron-down"  data-id="classification-subfields-{$record->id}" aria-hidden="true" title="show subfields"></i>
          {if $hasSubfields && isset($record->id) && isset($subfields[$record->id])}
            <div id="classification-subfields-{$record->id}" class="classification-subfields">
              <p>Which subfields are available in the individual instances of this field?</p>
              <table>
                <thead>
                  <tr>
                    <th>subfields</th>
                    <th class="count">count</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach $subfields[$record->id]['list'] as $item}
                    <tr>
                      <td>
                        {foreach $item->subfields as $subfield}
                          {assign var="sub" value={substr($subfield, 0, 2)}}
                          <a href="#completeness-{$record->field}{$sub}" class="completeness" data-field="{$record->field}{$sub}"
                          >{$subfield}</a>{if !$subfield@last}, {/if}
                        {/foreach}
                      </td>
                      <td class="count">{$item->count|number_format}</td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
              <p>notes:</p>
              <ul>
                {foreach $subfieldsById[$record->id] as $item}
                  {assign var="key" value="{$record->field}{$item}"}
                  <li>
                    <a href="#completeness-{$record->field}{$item}" class="completeness" data-field="{$record->field}{$item}">{$item}</a>:
                    {if isset($elements[$key]) && $elements[$key] != ''}
                      {$elements[$key]}
                    {elseif $item == '$9'}
                      &mdash; <span>(locally defined subfield)</span>
                    {else}
                      &mdash; <span>(not defined in MARC21)</span>
                    {/if}
                  </li>
                {/foreach}
              </ul>
              {if $subfields[$record->id]['has-plus'] || $subfields[$record->id]['has-space']}
                <ul>
                  {if $subfields[$record->id]['has-plus']}
                    <li>+ sign denotes multiple instances</li>
                  {/if}
                  {if $subfields[$record->id]['has-space']}
                    <li>_ sign denotes space character</li>
                  {/if}
                </ul>
              {/if}
            </div>
          {/if}
        </td>
        <td class="text-right">{$record->instancecount|number_format}</td>
        <td class="text-right">{$record->recordcount|number_format}</td>
      </tr>
      {assign var=previous value=$record->id}
    {/foreach}
  </tbody>
</table>


<script>
// $()
$('table#classification i').click(function (event) {
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