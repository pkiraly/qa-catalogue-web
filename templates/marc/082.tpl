{* Dewey Decimal Classification Number
   http://www.loc.gov/marc/bibliographic/bd082.html *}
{assign var="fieldInstances" value=getFields($record, '082')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>Dewey Decimal Classification</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="082">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="082a_ClassificationDdc_ss" title="Classification number">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="#" class="subdivision" data="082b_ClassificationDdc_itemPortion_ss" title="Subject category code subdivision">{$field->subfields->b}</a>
      {/if}

      {if isset($field->subfields->m)}
        <span class="designation" data="072x" title="Standard or optional designation">{$field->subfields->m}</span>
      {/if}

      {if isset($field->subfields->q)}
        <span class="agency" data="072x" title="Assigning agency">{$field->subfields->q}</span>
      {/if}

      {if isset($field->subfields->{'2'})}
        <a href="#" class="source" data="0822_ClassificationDdc_edition_ss" title="Source">{$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
