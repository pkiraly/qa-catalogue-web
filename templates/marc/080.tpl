{assign var="fieldInstances" value=getFields($record, '080')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>Universal Decimal Classification</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="080">
      {*  Personal name *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="udc"></i>
        <a href="#" class="record-link" data="080a">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="#" class="item-number" data="080b">{$field->subfields->b}</a>
      {/if}

      {if isset($field->subfields->x)}
        <a href="#" class="common-auxiliary-subdivision" data="080x">{$field->subfields->x}</a>
      {/if}

      {if isset($field->subfields->{'2'})}
        <a href="#" class="edition" data="0802">{$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
