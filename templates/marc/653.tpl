{assign var="fieldInstances" value=getFields($record, '653')}
{if !is_null($fieldInstances)}
  <em>Uncontrolled Index Term</em><br>
    {foreach $fieldInstances as $field}
      <span class="653">
          {if isset($field->subfields->a)}
            <a href="#" class="record-link" data="653a">{$field->subfields->a}</a>
          {/if}
        </span>
      <br/>
    {/foreach}
{/if}
