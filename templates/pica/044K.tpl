{if !is_null($record->getFields('044K')) || !is_null($record->getFields('045B'))}
<tr>
  <td class="record-field-label">Schlagwortfolge:</td>
  <td>
    {assign var="fieldInstances" value=$record->getFields('044K')}
    {if !is_null($fieldInstances)}
      {foreach from=$fieldInstances item=field name="fields"}
        {if isset($field->subfields->a) || isset($field->subfields->A)}
          {if isset($field->subfields->{'9'})}
            <a href="?tab=data&query=044K9_ss:{$field->subfields->{'9'}}">
              {if isset($field->subfields->a)}<span class="044K$a">{$field->subfields->a}</span>{/if}
              {if isset($field->subfields->g)}(<span class="044K$g">{$field->subfields->g}</span>){/if}
              {if isset($field->subfields->A)}<span class="044K$a">{$field->subfields->A}</span>{/if}
              {if isset($field->subfields->G)}(<span class="044K$G">{$field->subfields->G}</span>){/if}
            </a>
          {else}
            <span class="044K$a">{$field->subfields->a}</span>
          {/if}
          {if !$smarty.foreach.fields.last}<br/>{/if}
        {/if}
      {/foreach}
    {/if}

    {assign var="fieldInstances" value=$record->getFields('045B')}
    {if !is_null($fieldInstances)}
      {foreach from=$fieldInstances item=field name="fields"}
        {if isset($field->subfields->a) || isset($field->subfields->A)}
          {if isset($field->subfields->{'9'})}
            <a href="?tab=data&query=045B9_ss:{$field->subfields->{'9'}}">
              {if isset($field->subfields->a)}<span class="044K$a">{$field->subfields->a}</span>{/if}
              {if isset($field->subfields->g)}(<span class="044K$g">{$field->subfields->g}</span>){/if}
              {if isset($field->subfields->A)}<span class="044K$a">{$field->subfields->A}</span>{/if}
              {if isset($field->subfields->G)}(<span class="044K$G">{$field->subfields->G}</span>){/if}
            </a>
          {else}
            <span class="044K$a">{$field->subfields->a}</span>
          {/if}
          {if !$smarty.foreach.fields.last}<br/>{/if}
        {/if}
      {/foreach}
    {/if}
  </td>
</tr>
{/if}
