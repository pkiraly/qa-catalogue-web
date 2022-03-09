{if (isset($obj) && isset($key) && property_exists($obj, $key))}
  {assign var=var value=$obj->$key}
{/if}
{if isset($var)}
  {if isset($label)}{$label}{/if}
  {foreach $var as $value}
    {if isset($tag)}
      {if gettype($tag) != 'string'}{json_encode($tag)}{/if}
      <span class="tag-{$tag}">{$value}</span>{if !$value@first}, {/if}
    {else}
      {$value}{if !$value@first}, {/if}
    {/if}
  {/foreach}
  {if isset($suffix)}{$suffix}{/if}
{/if}
