<h4>General Information</h4>

{assign var="type" value=$record->getFirstField('type_ss')}
<p>
  008: "{str_replace(' ', '&nbsp;', $record->getFirstField('008_GeneralInformation_ss', TRUE))}"<br/>
  type*: {$type}<br/>
  Field 008 contains general information. It is a row of fixed-length data elements, such that
  there is no formal separators between elements, only the standard sets the boundaries
  by its positions (e.g. 00-05 means that the part of the whole string from 0th to 5th character).
  008 separates the string into three blocks: from 0 to 17th position it encodes general
  information, from 18th to 34th comes information specific to the record's type, and from 35th
  till the end of the string the general information continues.
  Some parts contain numeric values, such as length of the record, some others contain
  encoded information (e.g. in 6th position "s" means <em>Single known date/probable date</em>).
</p>

<p>* Type comes from the combination of type of record (06) and bibliographic level (07) positions of the Leader.
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
  {assign var="prevType" value=0}
  {foreach $controller->get008Definition($type) as $id => $data}
    {if $prevType != $data->type}
      {if $data->type == 1}
        <tr>
          <td colspan="4"><strong>Positions for all document types</strong></td>
        </tr>
      {else}
        <tr>
          <td colspan="4"><strong>Positions specific for {$type}</strong></td>
        </tr>
      {/if}
    {/if}
    <tr>
      <td {if $data->type == 2}style="border-left: 1px solid black;"{/if}>{$id}</td>
      <td>{$data->label}</td>
        {assign var="code" value=$record->get008ByPosition($data->start, $data->end)}
      <td>
        {if preg_match('/ /', $code)}
          "{str_replace(' ', '&nbsp;', $code)}"
        {else}
          {$code}
        {/if}
      </td>
      <td>{$record->resolve008($data, $code)}</td>
    </tr>
    {assign var="prevType" value=$data->type}
  {/foreach}
  </tbody>
</table>
