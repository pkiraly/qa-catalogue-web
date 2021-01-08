{assign var="fieldInstances" value=$record->getFields('700')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>additional personal names</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="700">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      {foreach $field->subfields as $code => $value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('700a_AddedPersonalName_personalName_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'b'}
          numeration: <a href="{$record->filter('700b_AddedPersonalName_numeration_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'c'}
          titles: <a href="{$record->filter('700c_AddedPersonalName_titlesAndWords_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'd'}
          dates: <a href="{$record->filter('700d_AddedPersonalName_dates_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'e'}
          relator: <a href="{$record->filter('700e_AddedPersonalName_relatorTerm_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'f'}
          date of a work: <a href="{$record->filter('700f_AddedPersonalName_dateOfAWork_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'g'}
          miscellaneous: <a href="{$record->filter('700g_AddedPersonalName_miscellaneous_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'h'}
          medium: <a href="{$record->filter('700h_AddedPersonalName_medium_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'i'}
          relationship: <a href="{$record->filter('700i_AddedPersonalName_relationship_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'j'}
          attribution: <a href="{$record->filter('700j_AddedPersonalName_attributionQualifier_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'k'}
          form: <a href="{$record->filter('700k_AddedPersonalName_formSubheading_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'l'}
          language: <a href="{$record->filter('700l_AddedPersonalName_language_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'm'}
          number of part/section/meeting: <a href="{$record->filter('700m_AddedPersonalName_mediumOfPerformance_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'n'}
          number of part/section/meeting: <a href="{$record->filter('700n_AddedPersonalName_numberOfPart_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'o'}
          arranged statement for music: <a href="{$record->filter('700o_AddedPersonalName_arrangedStatement_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'p'}
          name of part/section of a work: <a href="{$record->filter('700p_AddedPersonalName_nameOfPart_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'q'}
          fuller form of name: <a href="{$record->filter('700q_AddedPersonalName_fullerForm_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'r'}
          key for music: <a href="{$record->filter('700r_AddedPersonalName_keyForMusic_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 's'}
          version: <a href="{$record->filter('700s_AddedPersonalName_version_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 't'}
          title: <a href="{$record->filter('700t_AddedPersonalName_titleOfAWork_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'u'}
          affiliation: <a href="{$record->filter('700u_AddedPersonalName_affiliation_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'x'}
          ISSN: <a href="{$record->filter('700x_AddedPersonalName_issn_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '0'}
          authority: <a href="{$record->filter('7000_AddedPersonalName_authorityRecordControlNumber_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '1'}
          uri: <span class="titles">{$value}</span>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('7002_AddedPersonalName_source_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '3'}
          source: <a href="{$record->filter('7003_AddedPersonalName_materialsSpecified_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('7004_AddedPersonalName_relatorCode_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '5'}
          institution: <a href="{$record->filter('7005_AddedPersonalName_institutionToWhichFieldApplies_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
