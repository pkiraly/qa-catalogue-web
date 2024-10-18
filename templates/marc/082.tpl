{* Dewey Decimal Classification Number
   http://www.loc.gov/marc/bibliographic/bd082.html *}
{assign var="fieldInstances" value=$record->getFields('082')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>Dewey Decimal Classification</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="082">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="{$record->filter('082a_ClassificationDdc_ss', $field->subfields->a)}" class="record-link" title="Classification number">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="#" class="subdivision" data="082b_ClassificationDdc_itemPortion_ss" title="Subject category code subdivision">{include 'data/subfield.tpl' value=$field->subfields->b}</a>
      {/if}

      {if isset($field->subfields->m)}
        <span class="designation" data="072x" title="Standard or optional designation">{include 'data/subfield.tpl' value=$field->subfields->m}</span>
      {/if}

      {if isset($field->subfields->q)}
        <span class="agency" data="082q_ClassificationDdc_source_ss" title="Assigning agency">{include 'data/subfield.tpl' value=$field->subfields->q}</span>
      {/if}

      {if property_exists($field->subfields, '2')}
        <a href="{$record->filter('0822_ClassificationDdc_edition_ss', $field->subfields->{'2'})}" class="source" title="Source">{include 'data/subfield.tpl' value=$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
