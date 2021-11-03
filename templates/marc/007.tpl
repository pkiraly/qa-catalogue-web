<h4>Physical Description-General Information</h4>

{assign var="type" value=$record->get007Category()}
<p>
  007: "{str_replace(' ', '&nbsp;', $record->getField('007'))}"<br/>
  category: {$type}<br/>
  Special information about the physical characteristics in a coded form. The information
  may represent the whole item or parts of an item such as accompanying material. The
  physical characteristics are often related to information in other parts of the MARC
  record especially from field 300 (Physical Description) or one of the 5XX note fields.
</p>

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
  {foreach $controller->get007Definition($type) as $id => $data}
    <tr>
      <td>{$id}</td>
      <td>{$data->label}</td>
        {assign var="code" value=$record->get007ByPosition($data->start, $data->end)}
      <td>
        {if preg_match('/ /', $code)}
          "{str_replace(' ', '&nbsp;', $code)}"
        {else}
          {$code}
        {/if}
      </td>
      <td>{$record->resolve008($data, $code)}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
