{* Subject Category Code
   http://www.loc.gov/marc/bibliographic/bd072.html *}
{assign var="fieldInstances" value=$record->getFields('072')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>subject category code</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="072">
      {*  Subject category code *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Subject category code"></i>
        <a href="{$record->filter('072a_SubjectCategoryCode_ss', $field->subfields->a)}" class="record-link" title="Subject category code">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->x)}
        <a href="{$record->filter('072x', $field->subfields->x)}" class="common-auxiliary-subdivision" title="Subject category code subdivision">{$field->subfields->x}</a>
      {/if}

      {if property_exists($field->subfields, '2')}
        <a href="{$record->filter('0722', $field->subfields->{'2'})}" class="source" title="Source">{$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
