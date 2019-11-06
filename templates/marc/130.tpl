{* Main Entry - Uniform Title, https://www.loc.gov/marc/bibliographic/bd130.html *}
{assign var="fieldInstances" value=getFields($record, '130')}
{if !is_null($fieldInstances)}
  <em>uniform title</em><br>
  {foreach $fieldInstances as $field}
    <span class="130">
      <i class="fa fa-user" aria-hidden="true" title="title"></i>
      <a href="#" class="record-link" data="130a_MainUniformTitle_ss">{$field->subfields->a}</a>
      {*  *}
      {if isset($field->subfields->b)}
        <span class="numeration">{$field->subfields->b}</span>
      {/if}
      {* 111c_MainMeetingName_locationOfMeeting_ss *}
      {if isset($field->subfields->c)}
        <span class="location">{$field->subfields->c}</span>
      {/if}
      {* 111d_MainMeetingName_dates_ss *}
      {if isset($field->subfields->d)}
        <span class="dates">{$field->subfields->d}</span>
      {/if}
      {* 111e_MainMeetingName_subordinateUnit_ss *}
      {if isset($field->subfields->e)}
        <span class="unit">{$field->subfields->e}</span>
      {/if}
      {* 130f_MainUniformTitle_dateOfAWork_ss *}
      {if isset($field->subfields->f)}
        <span class="date-of-a-work">{$field->subfields->f}</span>
      {/if}
      {* 130g_MainUniformTitle_miscellaneous_ss *}
      {if isset($field->subfields->g)}
        <span class="misc">{$field->subfields->g}</span>
      {/if}
      {* 111j_MainMeetingName_relatorTerm_ss *}
      {if isset($field->subfields->j)}
        <span class="dates">{$field->subfields->j}</span>
      {/if}
      {* 130k_MainUniformTitle_formSubheading_ss *}
      {if isset($field->subfields->k)}
        <span class="dates">{$field->subfields->k}</span>
      {/if}
      {* 130m_MainUniformTitle_mediumOfPerformance_ss *}
      {if isset($field->subfields->m)}
        <span class="medium">{$field->subfields->m}</span>
      {/if}
      {* 130n_MainUniformTitle_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="part">{$field->subfields->n}</span>
      {/if}
      {* 130o_MainUniformTitle_arrangedStatement_ss *}
      {if isset($field->subfields->o)}
        <span class="statement">{$field->subfields->o}</span>
      {/if}
      {* 130p_MainUniformTitle_nameOfPart_ss *}
      {if isset($field->subfields->p)}
        <span class="part-name">{$field->subfields->p}</span>
      {/if}
      {* 130r_MainUniformTitle_keyForMusic_ss *}
      {if isset($field->subfields->r)}
        <span class="key">{$field->subfields->r}</span>
      {/if}
      {* 130s_MainUniformTitle_version_ss *}
      {if isset($field->subfields->s)}
        <span class="version">{$field->subfields->s}</span>
      {/if}
      {* 1300_MainUniformTitle_authorityRecordControlNumber_ss *}
      {if isset($field->subfields->{'0'})}
        [<a href="#" class="record-link" data="1300_MainUniformTitle_authorityRecordControlNumber_ss">
        <span class="version">{$field->subfields->{'0'}}</span></a>]
      {/if}
    </span>
    <br/>
  {/foreach}
{/if}
