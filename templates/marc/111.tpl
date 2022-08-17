{* Main Entry-Meeting Name, https://www.loc.gov/marc/bibliographic/bd111.html *}
{assign var="fieldInstances" value=$record->getFields('111')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>main meeting names</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="111">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      <a href="{$record->filter('111a_MainMeetingName_ss', $field->subfields->a)}" class="record-link">{$field->subfields->a}</a>
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
      {* 110g_MainCorporateName_miscellaneous_ss *}
      {if isset($field->subfields->g)}
        <span class="misc">{$field->subfields->g}</span>
      {/if}
      {* 111j_MainMeetingName_relatorTerm_ss *}
      {if isset($field->subfields->j)}
        <span class="dates">{$field->subfields->j}</span>
      {/if}
      {* 111n_MainMeetingName_numberOfPart_ss *}
      {if isset($field->subfields->n)}
        <span class="part">{$field->subfields->n}</span>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
