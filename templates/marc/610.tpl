{assign var="fieldInstances" value=getFields($record, '610')}
{if !is_null($fieldInstances)}
  <em>Corporate names as subjects</em><br>
    {foreach $fieldInstances as $field}
      <span class="600">
          {*  Personal name *}
          {if isset($field->subfields->a)}
            <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
            <a href="#" class="record-link" data="610a">{$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->b)}
            <span class="numeration" data="610b">{$field->subfields->b}</span>
          {/if}

          {if isset($field->subfields->c)}
            <span class="titles" data="610c">{$field->subfields->c}</span>
          {/if}

          {if isset($field->subfields->d)}
            <span class="dates" data="610d">{$field->subfields->d}</span>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {* 6500_Topic_authorityRecordControlNumber_ss *}
          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="6100">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
      <br/>
    {/foreach}
{/if}
