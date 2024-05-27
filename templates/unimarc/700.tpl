{assign var="fieldInstances" value=$record->getFields('700')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>personal names - primary responsibility</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="700">
      <i class="fa fa-user" aria-hidden="true" title="personal name"></i>
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('700a_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          part of name: <a href="{$record->filter('700b_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          additions to names: <a href="{$record->filter('700c_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          roman numerals: <a href="{$record->filter('700d_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          dates: <a href="{$record->filter('700f_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          expansions of initials: <a href="{$record->filter('700g_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'k'}
          attribution: <a href="{$record->filter('700k_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'o'}
          international standard identifier: <a href="{$record->filter('700o_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'p'}
          affiliation: <a href="{$record->filter('700p_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('7002_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '3'}
          authority ID: <a href="{$record->filter('7003_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('7004_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '8'}
          materials specified: <a href="{$record->filter('7008_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
    </td>
  </tr>
{/if}
