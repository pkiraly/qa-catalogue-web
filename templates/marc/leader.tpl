<h4>Leader</h4>

<p>
  Leader: "{str_replace(' ', '&nbsp;', $record->getFirstField('Leader_ss', TRUE))}"<br/>
  type*: {$record->getFirstField('type_ss')}<br>
  Leader contains general information. It is a row of fixed-length data elements, such that
  there is no formal separators between elements, only the standard sets the boundaries
  by its positions (e.g. 00-04 means that the part of the whole string from 0th to 4th character).
  Some parts contain numeric values, such as lenght of the record, some others contain
  encoded information (e.g. in 6th position "a" means <em>Language material</em>).
</p>

<p>* Type comes from the combination of type of record (06) and bibliographic level (07) positions.
  See 'Dependencies' section of
  <a href="https://www.loc.gov/marc/bibliographic/bdleader.html" target="_blank">Leader</a></p>

<table class="explanation">
  <thead>
  <tr>
    <th>pos.</th>
    <th>meaning of position</th>
    <th>value</th>
    <th>meaning of value</th>
  </tr>
  </thead>
  <tbody>
  {foreach from=$controller->getFieldDefinitions()->fields->LDR->positions key=id item=data}
    <tr>
      <td>{$id}</td>
      <td>{$data->label}</td>
        {assign var="code" value=$record->getLeaderByPosition($data->start, $data->end)}
      <td>
        {if preg_match('/ /', $code)}
          "{str_replace(' ', '&nbsp;', $code)}"
        {else}
          {$code}
        {/if}
      </td>
      <td>{$record->resolveLeader($data, $code)}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
