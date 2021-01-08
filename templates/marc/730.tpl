{* Added Entry - Uniform Title, https://www.loc.gov/marc/bibliographic/bd730.html *}
{assign var="fieldInstances" value=$record->getFields('730')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uniform title</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="730">
      <i class="fa fa-user" aria-hidden="true" title="Uniform title"></i>
      <a href="{$record->filter('730a_AddedUniformTitle_ss', $field->subfields->a)}" class="record-link" title="Uniform title">{$field->subfields->a}</a>
      {*  *}
      {if isset($field->subfields->d)}
        <span class="date" title="Date of treaty signing">{$field->subfields->d}</span>
      {/if}
      {* 730f_AddedUniformTitle_dateOfAWork_ss *}
      {if isset($field->subfields->f)}
        <span class="date-of-a-work" title="Date of a work">{$field->subfields->f}</span>
      {/if}
      {* 730g_AddedUniformTitle_miscellaneous_ss *}
      {if isset($field->subfields->g)}
        <span class="misc" title="Miscellaneous information">{$field->subfields->g}</span>
      {/if}
      {* 111j_MainMeetingName_relatorTerm_ss *}
      {if isset($field->subfields->h)}
        <span class="medium" title="Medium">{$field->subfields->h}</span>
      {/if}
      {if isset($field->subfields->i)}
        <span class="form" title="Relationship information">{$field->subfields->i}</span>
      {/if}
      {* 730k_AddedUniformTitle_formSubheading_ss *}
      {if isset($field->subfields->k)}
        <span class="form" title="Form subheading">{$field->subfields->k}</span>
      {/if}
      {if isset($field->subfields->l)}
        <span class="form" title="Language of a work">{$field->subfields->l}</span>
      {/if}
      {* 730m_AddedUniformTitle_mediumOfPerformance_ss *}
      {if isset($field->subfields->m)}
        <span class="medium" title="Medium of performance for music">{$field->subfields->m}</span>
      {/if}
      {* 730n_AddedUniformTitle_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="part" title="Number of part/section of a work">{$field->subfields->n}</span>
      {/if}
      {* 730o_AddedUniformTitle_arrangedStatement_ss *}
      {if isset($field->subfields->o)}
        <span class="statement" title="Arranged statement for music">{$field->subfields->o}</span>
      {/if}
      {* 730p_AddedUniformTitle_nameOfPart_ss *}
      {if isset($field->subfields->p)}
        <span class="part-name" title="Name of part/section of a work">{$field->subfields->p}</span>
      {/if}
      {* 730r_AddedUniformTitle_keyForMusic_ss *}
      {if isset($field->subfields->r)}
        <span class="key" title="Key for music">{$field->subfields->r}</span>
      {/if}
      {* 130s_MainUniformTitle_version_ss *}
      {if isset($field->subfields->s)}
        <span class="version" title="Version">{$field->subfields->s}</span>
      {/if}
      {if isset($field->subfields->t)}
        <span class="version" title="Title of a work">{$field->subfields->t}</span>
      {/if}
      {if isset($field->subfields->x)}
        <span class="version" title="International Standard Serial Number">{$field->subfields->x}</span>
      {/if}
      {* 7300_AddedUniformTitle_authorityRecordControlNumber_ss *}
      {if isset($field->subfields->{'0'})}
        [<a href="{$record->filter('7300_AddedUniformTitle_authorityRecordControlNumber_ss', $field->subfields->{'0'})}" class="record-link">
        <span class="version" title="Authority record control number or standard number">{$field->subfields->{'0'}}</span></a>]
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
