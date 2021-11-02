{assign var="type" value=$record->get006Type()}
<p>
  006:
    {if gettype($record->getFields('006') == 'string')}
      "{$record->getFields('006')}"
    {else}
      "{implode('", "', $record->getFields('006'))}"
    {/if}<br/>
  type*: {$type}<br/>
</p>

<table>
  <thead>
    <tr>
      <th>pos.</th>
      <th>- meaning of position</th>
      <th>value</th>
      <th>- meaning of value</th>
    </tr>
  </thead>
  <tbody>
  {assign var="prevType" value=0}
  {foreach $controller->get006Definition($type) as $id => $data}
    <tr>
      <td>{$id}</td>
      <td>{$data->label}</td>
      {assign var="code" value=$record->get006ByPosition($data->start, $data->end)}
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
