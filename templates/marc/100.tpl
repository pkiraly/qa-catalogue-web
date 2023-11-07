{* 100a_MainPersonalName_personalName_ss *}
{assign var="fieldInstances" value=$record->getFields('100')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>main personal names</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="100">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('100a_MainPersonalName_personalName_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          numeration: <a href="{$record->filter('100b_MainPersonalName_numeration_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          titles: <a href="{$record->filter('100c_MainPersonalName_titlesAndWords_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          dates: <a href="{$record->filter('100d_MainPersonalName_dates_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'e'}
          relator: <a href="{$record->filter('100e_MainPersonalName_relatorTerm_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          date of a work: <a href="{$record->filter('100f_MainPersonalName_dateOfAWork_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          miscellaneous: <a href="{$record->filter('100g_MainPersonalName_miscellaneous_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'j'}
          attribution: <a href="{$record->filter('100j_MainPersonalName_attributionQualifier_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'k'}
          form: <a href="{$record->filter('100k_MainPersonalName_formSubheading_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'l'}
          language: <a href="{$record->filter('100l_MainPersonalName_language_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'n'}
          number of part/section/meeting: <a href="{$record->filter('100n_MainPersonalName_numberOfPart_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'p'}
          name of part/section of a work: <a href="{$record->filter('100p_MainPersonalName_nameOfPart_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'q'}
          fuller form of name: <a href="{$record->filter('100q_MainPersonalName_fullerForm_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 't'}
          title: <a href="{$record->filter('100t_MainPersonalName_titleOfAWork_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'u'}
          affiliation: <a href="{$record->filter('100u_MainPersonalName_affiliation_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '0'}
          authority ID: <a href="{$record->filter('1000_MainPersonalName_authorityRecordControlNumber_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '1'}
          uri: <span class="titles">{$value}</span>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('1002_MainPersonalName_source_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('1004_MainPersonalName_relatorCode_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
    </td>
  </tr>
{/if}
