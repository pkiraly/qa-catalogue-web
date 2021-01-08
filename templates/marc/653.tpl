{assign var="fieldInstances" value=$record->getFields('653')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uncontrolled terms</em>:</td>
  <td>
    {foreach $fieldInstances as $field}
      <span class="653">
        {if isset($field->subfields->a)}
          <a href="{$record->filter('653a_UncontrolledIndexTerm_ss', $field->subfields->a)}" class="record-link">{$field->subfields->a}</a>
        {/if}
      </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
