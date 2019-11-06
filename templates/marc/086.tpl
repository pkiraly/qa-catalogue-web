{* Government Document Classification Number
   http://www.loc.gov/marc/bibliographic/bd086.html *}
{assign var="fieldInstances" value=getFields($record, '086')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>government document classifications</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="086">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="#" class="record-link" data="086a_GovernmentDocumentClassification_ss" title="Classification number">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->z)}
        <a href="#" class="cancelled" data="086z"
           title="Canceled/invalid classification number">{$field->subfields->z}</a>
      {/if}

      {if isset($field->ind1) && $field->ind1 != ' '}
        <a href="#" class="source" data="086ind1_GovernmentDocumentClassification_numberSource_ss" title="Source">{$field->ind1}</a>
      {else}
        {if isset($field->subfields->{'2'})}
          <a href="#" class="source" data="0862_GovernmentDocumentClassification_source_ss" title="Source">{$field->subfields->{'2'}}</a>
        {/if}
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
