{assign var="fieldInstances" value=getFields($record, '600')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>personal names</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="600">
      {*  Personal name *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Personal name"></i>
        <a href="#" class="record-link" data="600a_PersonalNameSubject_personalName_ss">{$field->subfields->a}</a>
      {/if}

      {*  Numeration *}
      {if isset($field->subfields->b)}
        <span class="numeration" data="600b_PersonalNameSubject_numeration_ss">{$field->subfields->b}</span>
      {/if}

      {*  Numeration *}
      {if isset($field->subfields->c)}
        <span class="titles" data="600c_PersonalNameSubject_titlesAndWords_ss">{$field->subfields->c}</span>
      {/if}

      {*  Numeration *}
      {if isset($field->subfields->d)}
        <span class="dates" data="600d_PersonalNameSubject_dates_ss">{$field->subfields->d}</span>
      {/if}

      {if isset($field->subfields->{'2'})}
        vocabulary: {$field->subfields->{'2'}}</a>
      {/if}

      {* 6500_Topic_authorityRecordControlNumber_ss *}
      {if isset($field->subfields->{'0'})}
        (authority: <a href="#" class="record-link" data="6000_PersonalNameSubject_authorityRecordControlNumber_ss">{$field->subfields->{'0'}}</a>)
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
