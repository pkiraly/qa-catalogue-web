{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('773')}
{if !is_null($fieldInstances)}
<p>
  {foreach $fieldInstances as $field name=fields}
    <span class="773">
      {foreach $field->subfields as $code => $value name=subfields}
        {if $code == 't' || $code == 'n'}
          <span class="{$code}">{$value}</span>
        {/if}
      {/foreach}
    </span>
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
</p>
{/if}
