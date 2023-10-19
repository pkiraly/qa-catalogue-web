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
              {include 'common/parameters-object-value.tpl' parent=$value}
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