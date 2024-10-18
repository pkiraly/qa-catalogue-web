{assign var="fieldInstances" value=$record->getFields('730')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uniform title</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="730">
      <i class="fa fa-user" aria-hidden="true" title="name - entity responsible"></i>
      <a href="{$record->filter('730a_ss', $field->subfields->a)}" class="record-link" title="name - entity responsible">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
