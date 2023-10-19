{foreach from=get_object_vars($parent) key=key item=value name=list}
  {$key}:
  {if is_bool($value)}{if $value}{_('true')}{else}{_('false')}{/if}
  {elseif is_null($value)}&mdash;
  {elseif is_string($value)}{$value}
  {elseif is_array($value)}{if empty($value)}&mdash;{else}{join(', ', $value)}{/if}
  {elseif is_object($value)}{include 'common/parameters-object-value.tpl' parent=$value}
  {else}{json_encode($value1)} ({gettype($value1)}){/if}{if !$smarty.foreach.list1.last},{/if}
{/foreach}
