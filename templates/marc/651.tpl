{* 6510_Geographic_authorityRecordControlNumber_ss *}
{assign var="fieldInstances" value=getFields($record, '651')}
{if !is_null($fieldInstances)}
  <em>Geographic names</em><br>
    {foreach $fieldInstances as $field}
      <span class="651">
          {if isset($field->subfields->a)}
            <i class="fa fa-map" aria-hidden="true" title="geographic term"></i>
            <a href="#" class="record-link" data="650a">{$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="6510_Geographic_authorityRecordControlNumber_ss">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
      <br/>
    {/foreach}
{/if}
