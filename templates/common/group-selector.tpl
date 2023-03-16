{if $groupped}
  <div id="group-selector">
    <form>
      <input type="hidden" name="tab" value="{$tab}">
      {if isset($params)}
        {foreach from=$params key="key" item="value"}
          {if is_array($value)}
            {foreach from=$value item="v"}
              <input type="hidden" name="{$key}[]" value="{if strstr($v, '"')}{$v|urlencode}{else}{$v}{/if}">
            {/foreach}
          {else}
            <input type="hidden" name="{$key}" value="{$value}">
          {/if}
        {/foreach}
      {/if}
      <select name="groupId" onchange="this.form.submit()">
        {foreach from=$groups item=group}
          <option value="{$group->id}"{if ($group->id == $groupId)} selected="selected"{/if}>{$group->group} ({$group->count})</option>
        {/foreach}
      </select>
    </form>
  </div>
{/if}
