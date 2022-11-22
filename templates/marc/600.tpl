{assign var="fieldInstances" value=$record->getFields('600')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>personal names</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="600">
      <i class="fa fa-hashtag" aria-hidden="true" title="Personal name"></i>
      {*  Personal name *}
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('600a_PersonalNameSubject_personalName_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'b'}
          numeration: <a href="{$record->filter('600b_PersonalNameSubject_numeration_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'c'}
          titles: <a href="{$record->filter('600c_PersonalNameSubject_titlesAndWords_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == 'd'}
          dates: <a href="{$record->filter('600d_PersonalNameSubject_dates_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {elseif $code == '2'}
          vocabulary: {$value}</a>{$comma}
        {elseif $code == '0'}
          authority: <a href="{$record->filter('6000_PersonalNameSubject_authorityRecordControlNumber_ss', $value)}" class="record-link">{$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
