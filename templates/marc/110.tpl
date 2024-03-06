{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('110')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>main corporate names</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="110">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('110a_MainCorporateName_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          subordinate unit: <a href="{$record->filter('110b_MainCorporateName_subordinateUnit_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          meeting location: <a href="{$record->filter('110c_MainCorporateName_locationOfMeeting_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          date of meeting/treaty signing: <a href="{$record->filter('110d_MainCorporateName_dates_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'e'}
          relator: <a href="{$record->filter('110e_MainCorporateName_relatorTerm_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          dDate of a work: <a href="{$record->filter('110f_MainCorporateName_dateOfAWork_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          miscellaneous: <a href="{$record->filter('110g_MainCorporateName_miscellaneous_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'k'}
          form: <a href="{$record->filter('110k_MainCorporateName_formSubheading_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'l'}
          language: <a href="{$record->filter('110l_MainCorporateName_language_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'n'}
          number of part/section/meeting: <a href="{$record->filter('110n_MainCorporateName_numberOfPart_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'p'}
          name of part/section of a work: <a href="{$record->filter('110p_MainCorporateName_nameOfPart_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 't'}
          title: <a href="{$record->filter('110t_MainCorporateName_titleOfAWork_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'u'}
          affiliation: {include 'data/subfield.tpl' value=$value}{$comma}
        {elseif $code == '0'}
          authority ID: <a href="{$record->filter('1100_MainCorporateName_authorityRecordControlNumber_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '1'}
          uri: <a href="{$record->filter('1101_MainCorporateName_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('1102_MainCorporateName_source_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('1104_MainCorporateName_relatorCode_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
