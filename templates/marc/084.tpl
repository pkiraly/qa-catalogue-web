{* Other Classificaton Number
   http://www.loc.gov/marc/bibliographic/bd084.html *}
{assign var="fieldInstances" value=$record->getFields('084')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>other classifications</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="084">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="{$record->filter('084a_Classification_classificationPortion_ss', $field->subfields->a)}" class="record-link" title="Classification number">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="#" class="subdivision" data="084b"
           title="Item number">{include 'data/subfield.tpl' value=$field->subfields->b}</a>
      {/if}

      {if isset($field->subfields->q)}
        <span class="agency" data="084q_Classification_assigner_ss"
              title="Assigning agency">{include 'data/subfield.tpl' value=$field->subfields->q}</span>
      {/if}

      {if property_exists($field->subfields, '2')}
        <a href="{$record->filter('0842_Classification_source_ss', $field->subfields->{'2'})}" class="source" title="Source">{include 'data/subfield.tpl' value=$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
