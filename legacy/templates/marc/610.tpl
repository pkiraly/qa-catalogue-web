{assign var="fieldInstances" value=getFields($record, '610')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>corporate names</em>:</td>
  <td>
  <em>Corporate names as subjects</em><br>
    {foreach $fieldInstances as $field}
      <span class="600">
          {*  Personal name *}
          {if isset($field->subfields->a)}
            <i class="fa fa-hashtag" aria-hidden="true" title="corporate"></i>
            <a href="#" class="record-link" data="610a_CorporateNameSubject_ss">{$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->b)}
            <span class="numeration" data="610b_CorporateNameSubject_subordinateUnit_ss">{$field->subfields->b}</span>
          {/if}

          {if isset($field->subfields->c)}
            <span class="titles" data="610c_CorporateNameSubject_locationOfMeeting_ss">{$field->subfields->c}</span>
          {/if}

          {if isset($field->subfields->d)}
            <span class="dates" data="610d_CorporateNameSubject_dates_ss">{$field->subfields->d}</span>
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
  </td>
</tr>
{/if}
