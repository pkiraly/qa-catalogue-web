{* PUBLICATION, DISTRIBUTION, ETC. *}
{assign var="fieldInstances" value=$record->getFields('210')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('publication')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="210">
          {foreach from=$field->subfields key=code item=value name=subfields}
            {if $code == 'c'}:{/if}
            <span class="{$code}">{htmlspecialchars($value)}</span>
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
