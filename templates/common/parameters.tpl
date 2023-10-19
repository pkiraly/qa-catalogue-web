{if !is_null($analysisParameters)}
<div id="parameters">
  <strong>{_('analysis parameters')}</strong>
  <table>
    {foreach from=get_object_vars($analysisParameters) key=parameter item=value}
      {if $parameter != "outputDir"}
        <tr>
          <td>{if $parameter == 'args'}{_('files')}{else}{$parameter}{/if}</td>
          <td>
            {if is_bool($value)}
              {if $value}{_('true')}{else}{_('false')}{/if}
            {elseif is_array($value)}
              {foreach from=$value item=item name=list}
                {if $parameter == 'args'}
                  {preg_replace('/^.*\/([^\/]+)$/', "$1", $item)}
                {else}
                  {$item}
                {/if}
                {if !$smarty.foreach.list.last}<br>{/if}
              {/foreach}
            {elseif is_object($value)}
              {foreach from=get_object_vars($value) key=key1 item=value1 name=list1}
                {$key1}:
                {if is_bool($value1)}{if $value1}{_('true')}{else}{_('false')}{/if}
                {elseif is_null($value1)}&mdash;
                {elseif is_string($value1)}{$value1}
                {elseif is_array($value1)}{if empty($value1)}&mdash;{else}{join(', ', $value1)}{/if}
                {else}{json_encode($value1)} ({gettype($value1)}){/if}{if !$smarty.foreach.list1.last},{/if}
              {/foreach}
            {elseif is_null($value)}
              &mdash;
            {else}
              {$value}
            {/if}
          </td>
        </tr>
      {/if}
    {/foreach}
  </table>
</div>
{/if}