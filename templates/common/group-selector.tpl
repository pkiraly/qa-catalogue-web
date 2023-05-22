{if $grouped}
  <div id="group-selector">
    <form>
      <input type="hidden" name="tab" value="{$tab}">
      {if isset($params)}
        {foreach from=$params key="key" item="value"}
          {if is_array($value)}
            {foreach from=$value item="v"}
              <input type="hidden" name="{$key}[]" value="{if strstr($v, '"')}{$v|htmlspecialchars}{else}{$v}{/if}">
            {/foreach}
          {else}
            <input type="hidden" name="{$key}" value="{$value}">
          {/if}
        {/foreach}
      {/if}

      {include 'common/library-selector.tpl'}
    </form>
  </div>
{/if}
