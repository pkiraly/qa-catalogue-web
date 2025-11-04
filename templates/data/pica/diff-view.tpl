{if $showRecordDiff}
  <h4>{_('Differences between the analysed record and its current status in the catalogue')}</h4>

  {if empty($diff)}
    {_t('It is not possible to retrieve the record')}
  {else}
    <p style="text-align: right; margin: 1em;">{_t('color codes')}:
      <span style="display: inline; color: blue">{_t('changes in the library catalogue')}</span>,
      <span style="display: inline; color: green">{_t('new field the library catalogue')}</span>,
      <span style="display: inline; color: red">{_t('removed from the library catalogue')}</span>
    </p>

      {foreach from=$diff key=tag item=tagValue}
        {assign var="prev_index" value=-1}
        {foreach from=$tagValue['instances'] key=instance_index item=instance}
          {if isset($instance['color'])}
            {assign var="color" value=$instance['color']}
            {assign var="subfields" value=$instance['subfields']}
          {else}
            {if isset($tagValue['color'])}
              {assign var="color" value=$tagValue['color']}
            {else}
              {assign var="color" value=""}
            {/if}
            {assign var="subfields" value=$instance}
          {/if}
          {foreach from=$subfields key=subfield_index item="subfield"}
            <div class="row" {if !empty($color)}style="color:{$color}"{/if}>
              <div class="col-1">{if $subfield_index == 0 && $instance_index != $prev_index}{$tag}{/if}</div>
              <div class="col-1">${$subfield['code']}</div>
              <div class="col-10" style="text-wrap: wrap;">{$subfield['value']}</div>
            </div>
          {/foreach}
          {assign var="prev_index" value=$instance_index}
        {/foreach}
      {/foreach}
  {/if}
{/if}