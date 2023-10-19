{if is_bool($value)}{if $value}{_('true')}{else}{_('false')}{/if}
{elseif is_null($value)}&mdash;
{elseif is_string($value)}{$value}
{elseif is_array($value)}
  {foreach from=$value item=item name=list}
    {include 'common/parameters-object-value.tpl' value=$item}{if !$smarty.foreach.list1.last},{/if}
  {/foreach}
{elseif is_object($value)}
  {foreach from=get_object_vars($value) key=key item=item name=list}
    {$key}: {include 'common/parameters-object-value.tpl' value=$item}{if !$smarty.foreach.list1.last},{/if}
  {/foreach}
{else}{json_encode($value1)} ({gettype($value1)}){/if}
