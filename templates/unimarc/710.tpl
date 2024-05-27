{assign var="fieldInstances" value=$record->getFields('710')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>corporate body names - primary responsibility</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="710">
      <i class="fa fa-user" aria-hidden="true" title="corporate name"></i>
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('710a_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          subdivision: <a href="{$record->filter('710b_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          additions to name: <a href="{$record->filter('710c_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          number of meeting: <a href="{$record->filter('710d_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          date of meeting: <a href="{$record->filter('710f_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          inverted element: <a href="{$record->filter('710g_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'h'}
          remaining part of name: <a href="{$record->filter('710h_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'o'}
          international standard identifier: <a href="{$record->filter('710o_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'p'}
          affiliation: <a href="{$record->filter('710p_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: <a href="{$record->filter('7102_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '3'}
          authority ID: <a href="{$record->filter('7103_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '4'}
          relationship: <a href="{$record->filter('7104_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '8'}
          materials specified: <a href="{$record->filter('7108_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
    </td>
  </tr>
{/if}
