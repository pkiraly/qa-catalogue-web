<h3>Classification schemes</h3>

<table id="classification">
  <thead>
    <tr>
      <th class="location">Location</th>
      <th class="scheme">Classification scheme</th>
      <th class="instances">Instances</th>
      <th class="records">Records</th>
    </tr>
  </thead>
  <tbody>
    {assign var=previous value=""}
    {foreach $records as $record}
      {if $previous != $record->field}
        <tr>
          <td colspan="3"><h4>{$record->field} &mdash; {$fields[$record->field]}</h4></td>
        </tr>
      {/if}
      <tr>
        <td>{$record->location}</td>
        <td>
          {if (isset($record->facet2))}
            <a href="#" class="term-link" data-facet="{$record->facet2}" data-query="*:*" data-scheme="{$record->scheme}">{$record->scheme}</a>
          {elseif (isset($record->facet) && isset($record->q))}
            <a href="#" class="term-link" data-facet="{$record->facet}" data-query="{$record->q}" data-scheme="{$record->scheme}">{$record->scheme}</a>
            {if strlen($record->abbreviation) > 0}({$record->abbreviation}){/if}
          {else}
            {$record->scheme}
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
                  {foreach $subfields[$record->id] as $item}
                    <tr>
                      <td>{join(', ', $item->subfields)}</td>
                      <td class="count">{$item->count|number_format}</td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
              <ul>
                <li>+ sign denotes multiple instances</li>
                <li>_ sign denotes space character</li>
              </ul>
            </div>
          {/if}
        </td>
        <td class="text-right">{$record->instancecount|number_format}</td>
        <td class="text-right">{$record->recordcount|number_format}</td>
      </tr>
      {assign var=previous value=$record->field}
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
</script>