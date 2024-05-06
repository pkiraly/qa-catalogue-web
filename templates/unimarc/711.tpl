{assign var="fieldInstances" value=$record->getFields('711')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>corporate body names - alternative responsibility</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="711">
      <i class="fa fa-user" aria-hidden="true" title="corporate name"></i>
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('711a_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          subdivision: <a href="{$record->filter('711b_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          additions to name: <a href="{$record->filter('711c_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          number of meeting: <a href="{$record->filter('711d_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          date of meeting: <a href="{$record->filter('711f_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          inverted element: <a href="{$record->filter('711g_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'h'}
          remaining part of name: <a href="{$record->filter('711h_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'o'}
          international standard identifier: <a href="{$record->filter('711o_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'p'}
          affiliation: <a href="{$record->filter('711p_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('7112_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '3'}
          authority ID: <a href="{$record->filter('7113_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('7114_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '8'}
          materials specified: <a href="{$record->filter('7118_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
    </td>
  </tr>
{/if}
