{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('245')}
{if !is_null($fieldInstances)}
<p>
  {foreach from=$fieldInstances item=field name=fields}
    <span class="245">
      {foreach from=$field->subfields key=code item=value name=subfields}
        {if $code == 'c' && $record->getLeaderByPosition(18) == 'c'}/{/if}
        {if $code == 'b' && $record->getLeaderByPosition(18) == 'c'}:{/if}
        <span class="{$code}">
          {if is_array($value)}
            {foreach from=$value item=v name=v}
              {htmlspecialchars($v)}{if !$smarty.foreach.v.last}, {/if}
            {/foreach}
          {else}
            {htmlspecialchars($value)}
          {/if}
        </span>
      {/foreach}
    </span>
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
</p>
{/if}
