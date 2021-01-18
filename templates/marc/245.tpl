{* Main Entry-Corporate Name, https://www.loc.gov/marc/bibliographic/bd110.html *}
{assign var="fieldInstances" value=$record->getFields('245')}
{if !is_null($fieldInstances)}
<p>
  {foreach $fieldInstances as $field name=fields}
    <span class="245">
      {foreach $field->subfields as $code => $value name=subfields}
        <span class="{$code}">{$value}</span>
      {/foreach}
    </span>
    {if !$smarty.foreach.fields.last}<br/>{/if}
  {/foreach}
</p>
{/if}
