{* 6550_GenreForm_authorityRecordControlNumber_ss *}
{assign var="fieldInstances" value=getFields($record, '655')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>genres</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="655">
      {if isset($field->subfields->a)}
        <a href="#" class="record-link" data="655a_GenreForm_ss">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->v)}
        form: <span class="form">{$field->subfields->v}</span>
      {/if}

      {if isset($field->subfields->{'2'}) || isset($field->subfields->{'0'})}[
        {if isset($field->subfields->{'2'})}
          vocabulary: <span class="source">{$field->subfields->{'2'}}</span>
        {/if}

        {if isset($field->subfields->{'0'})}
          <a href="#" class="record-link" data="6550_GenreForm_authorityRecordControlNumber_ss">{$field->subfields->{'0'}}</a>
        {/if}
      ]{/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
