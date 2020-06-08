{* Subject Category Code
   http://www.loc.gov/marc/bibliographic/bd072.html *}
{assign var="fieldInstances" value=getFields($record, '072')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>subject category code</em>:</td>
  <td>
  {foreach $fieldInstances as $field}
    <span class="072">
      {*  Subject category code *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Subject category code"></i>
        <a href="#" class="record-link" data="072a_SubjectCategoryCode_ss" title="Subject category code">{$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->x)}
        <a href="#" class="common-auxiliary-subdivision" data="072x" title="Subject category code subdivision">{$field->subfields->x}</a>
      {/if}

      {if isset($field->subfields->{'2'})}
        <a href="#" class="source" data="0722" title="Source">{$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
