{if (isset($obj) && isset($key) && isset($obj->$key))}
  {assign var=var value=$obj->$key}
{/if}
{if isset($var)}
  {if isset($label)}{$label}{/if}
  {foreach $var as $value}
    {if isset($tag)}<span class="tag-{$tag}">{/if}{$value}{if isset($tag)}</span>{/if}{if !$value@first}, {/if}
  {/foreach}
  {if isset($suffix)}{$suffix}{/if}
{/if}
