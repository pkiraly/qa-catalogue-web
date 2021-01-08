{* Government Document Classification Number
   http://www.loc.gov/marc/bibliographic/bd086.html *}
{assign var="fieldInstances" value=$record->getFields('086')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>government document classifications</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="086">
      {*  Classification number *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Classification number"></i>
        <a href="{$record->filter('086a_GovernmentDocumentClassification_ss', $field->subfields->a)}" class="record-link" title="Classification number">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->z)}
        <a href="{$record->filter('086z', $field->subfields->z)}" class="cancelled"
           title="Canceled/invalid classification number">{$field->subfields->z}</a>
      {/if}

      {if isset($field->ind1) && $field->ind1 != ' '}
        <a href="{$record->filter('086ind1_GovernmentDocumentClassification_numberSource_ss', $field->ind1)}" class="source" title="Source">{$field->ind1}</a>
      {else}
        {if isset($field->subfields->{'2'})}
          <a href="{$record->filter('0862_GovernmentDocumentClassification_source_ss', $field->subfields->{'2'})}" class="source" title="Source">{$field->subfields->{'2'}}</a>
        {/if}
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
