{strip}
  {if preg_match('/^ +$/', $message)}
    "{$message}"
  {else}
    {$match=[]}
    {if preg_match('/^there are ([0-9]+) instances$/', $message, $match)}
      {_t('there are %d instances', $match[1])}
    {else}
      {$message}
    {/if}
  {/if}
{/strip}
