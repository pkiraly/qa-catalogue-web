{foreach $items as $item}
  {if $item->url == ''}
    <strong>{$item->text}</strong>
  {else}
    <a href="?{$item->url}">{$item->text}</a>
  {/if}
{/foreach}
