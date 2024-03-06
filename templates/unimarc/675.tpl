{* UNIVERSAL DECIMAL CLASSIFICATION (UDC) *}
{assign var="fieldInstances" value=$record->getFields('675')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">{_('UDC')}:</td>
    <td>
      {foreach from=$fieldInstances item=field name=fields}
        <span class="675">
          {foreach from=$field->subfields key=code item=value name=subfields}
            {if $code == 'v'}
              (<span class="record-subfield-label">{_('edition')}:</span>
              <span class="{$code}">{htmlspecialchars($value)}</span>)
            {elseif $code == 'z'}
              (<span class="record-subfield-label">{_('language of edition')}:</span>
              <span class="{$code}">{htmlspecialchars($value)}</span>)
            {elseif $code == '3'}
              (<span class="record-subfield-label">{_('classification record number')}:</span>
              <span class="{$code}">{htmlspecialchars($value)}</span>)
            {else}
              <span class="{$code}">{htmlspecialchars($value)}</span>
            {/if}
          {/foreach}
        </span>
        {if !$smarty.foreach.fields.last}<br/>{/if}
      {/foreach}
    </td>
  </tr>
{/if}
