{* Added Entry - Uncontrolled Name, https://www.loc.gov/marc/bibliographic/bd720.html *}
{assign var="fieldInstances" value=$record->getFields('720')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uncontrolled name</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="720">
      <i class="fa fa-user" aria-hidden="true" title="Name"></i>
      <a href="{$record->filter('720a', $field->subfields->a)}" class="record-link" title="Name">{$field->subfields->a}</a>
      {*  *}
      {if isset($field->subfields->e)}
        <span class="date" title="Relator term">{$field->subfields->e}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
