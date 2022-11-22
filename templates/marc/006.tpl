<h4>Additional Material Characteristics</h4>

{assign var="type" value=$record->get006Type()}
<p>
  006:
    {if gettype($record->getFields('006') == 'string')}
      "{str_replace(' ', '&nbsp;', $record->getFields('006'))}"
    {else}
      "{implode('", "', str_replace(' ', '&nbsp;', $record->getFields('006')))}"
    {/if}<br/>
  type: {$type}<br/>
  Eighteen character positions (00-17) that provide for coding information about special
  aspects of the item being cataloged that cannot be coded in field 008 (Fixed-Length
  Data Elements). It is used in cases when an item has multiple characteristics (e.g.,
  printed material with an accompanying cassette or a map that is issued serially) and
  to record the coded serial aspects of nontextual continuing resources.<br/>

  It is also used to record the coded computer file aspects of electronic items coded
  in Leader/06 as something other than code m. The fixed-length data elements defined
  for field 006, like the corresponding field 008 data elements, are potentially useful
  for retrieval and data management purposes.<br/>

  Field has a generic tree structure, whereby the code given in 006/00 (Form of material) determines
  the data elements defined for subsequent character positions. Except for code s (Serial/Integrating
  resource), the codes in field 006/00 correspond to those in Leader/06 (Type of record). For
  each occurrence of field 006, the codes defined for character positions 01-17 will be
  the same as those defined in the corresponding field 008, character positions 18-34.
  Configurations of field 006 are given in the following order: books, computer files/electronic
  resources, maps, music, continuing resources, visual materials, and mixed materials.<br/>
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
  {assign var="prevType" value=0}
  {foreach from=$controller->get006Definition($type) key=id item=data}
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
