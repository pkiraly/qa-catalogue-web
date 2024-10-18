{assign var="fieldInstances" value=$record->getFields('601')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>corporate body names</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="601">
      <i class="fa fa-hashtag" aria-hidden="true" title="Personal name"></i>
      {*  Personal name *}
      {foreach from=$field->subfields key=code item=value name=subfields}
        {assign 'comma' value=(($smarty.foreach.subfields.last) ? '' : ',')}
        {if $code == 'a'}
          <a href="{$record->filter('601a_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'b'}
          subdivision: <a href="{$record->filter('601b_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'c'}
          addition to name: <a href="{$record->filter('601c_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'd'}
          number of meeting: <a href="{$record->filter('601d_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'l'}
          location of meeting: <a href="{$record->filter('601l_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'f'}
          date of meeting: <a href="{$record->filter('601f_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 'g'}
          expansion of initials: <a href="{$record->filter('601g_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == 't'}
          title: <a href="{$record->filter('601t_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {elseif $code == '2'}
          source: {$value}{$comma}
        {elseif $code == '3'}
          authority ID: <a href="{$record->filter('6013_ss', $value)}" class="record-link">{include 'data/subfield.tpl' value=$value}</a>{$comma}
        {/if}
      {/foreach}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
