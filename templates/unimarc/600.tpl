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
          <a href="{$record->filter('600a_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          remaining part of name: <a href="{$record->filter('600b_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          additions to name: <a href="{$record->filter('600c_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          roman numerals: <a href="{$record->filter('600d_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          dates: <a href="{$record->filter('600f_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          expansion of initials: <a href="{$record->filter('600g_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 't'}
          title: <a href="{$record->filter('600t_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: {$value}{$comma}
        {elseif $code == '3'}
          authority ID: <a href="{$record->filter('6003_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
