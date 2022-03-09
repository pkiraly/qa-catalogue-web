{* Added Entry-Meeting Name, https://www.loc.gov/marc/bibliographic/bd711.html *}
{assign var="fieldInstances" value=$record->getFields('711')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>additional meeting names</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="711">
      <i class="fa fa-user" aria-hidden="true" title="Meeting name or jurisdiction name as entry element"></i>
      <a href="{$record->filter('711a_AddedMeetingName_ss', $field->subfields->a)}" class="record-link" title="Meeting name or jurisdiction name as entry element">{$field->subfields->a}</a>
      {* 711c_AddedMeetingName_locationOfMeeting_ss *}
      {if isset($field->subfields->c)}
        <span class="location" title="Location of meeting">{$field->subfields->c}</span>
      {/if}
      {* 711d_AddedMeetingName_dates_ss *}
      {if isset($field->subfields->d)}
        <span class="dates" title="Date of meeting">{$field->subfields->d}</span>
      {/if}
      {* 711e_AddedMeetingName_subordinateUnit_ss *}
      {if isset($field->subfields->e)}
        <span class="unit" title="Subordinate unit">{$field->subfields->e}</span>
      {/if}
      {*  *}
      {if isset($field->subfields->f)}
        <span class="misc" title="Date of a work">{$field->subfields->f}</span>
      {/if}
      {* 711g_AddedMeetingName_miscellaneous_ss *}
      {if isset($field->subfields->g)}
        <span class="misc" title="Miscellaneous information">{$field->subfields->g}</span>
      {/if}
      {* 711j_AddedMeetingName_relatorTerm_ss *}
      {if isset($field->subfields->j)}
        <span class="dates" title="Relator term">{$field->subfields->j}</span>
      {/if}
      {* 711n_AddedMeetingName_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="dates" title="Number of part/section/meeting">{$field->subfields->n}</span>
      {/if}
      {* 711t_AddedMeetingName_titleOfAWork_ss *}
      {if isset($field->subfields->t)}
        <span class="part" title="Title of a work">{$field->subfields->t}</span>
      {/if}
      {* 7110_AddedMeetingName_authorityRecordControlNumber_ss *}
      {if property_exists($field->subfields, '0')}
        <span class="part" title="Authority record control number or standard number">{$field->subfields->{'0'}}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
