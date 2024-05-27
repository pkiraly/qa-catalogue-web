{assign var="fieldInstances" value=$record->getFields('712')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>corporate body names - secondary responsibility</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="712">
      <i class="fa fa-user" aria-hidden="true" title="corporate name"></i>
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('712a_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          subdivision: <a href="{$record->filter('712b_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          additions to name: <a href="{$record->filter('712c_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          number of meeting: <a href="{$record->filter('712d_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          date of meeting: <a href="{$record->filter('712f_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          inverted element: <a href="{$record->filter('712g_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'h'}
          remaining part of name: <a href="{$record->filter('712h_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'o'}
          international standard identifier: <a href="{$record->filter('712o_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'p'}
          affiliation: <a href="{$record->filter('712p_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('7122_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '3'}
          authority ID: <a href="{$record->filter('7123_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('7124_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '8'}
          materials specified: <a href="{$record->filter('7128_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
    </td>
  </tr>
{/if}
