{assign var="fieldInstances" value=getFields($record, '650')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>Topics</em></td>
  <td>
    {foreach $fieldInstances as $field}
        {* 650a_Topic_topicalTerm_ss *}
      <span class="650">
          {if isset($field->subfields->a)}
            <i class="fa fa-hashtag" aria-hidden="true" title="topical term"></i>
            <a href="#" class="record-link" data="650a_Topic_topicalTerm_ss">{$field->subfields->a}</a>
          {/if}

          {* 650z_Topic_geographicSubdivision_ss *}
          {if isset($field->subfields->z)}
            geo:
            <i class="fa fa-map" aria-hidden="true" title="geographic subdivision"></i>
            <a href="#" class="record-link" data="650z_Topic_geographicSubdivision_ss">{$field->subfields->z}</a>
          {/if}

          {* 650v_Topic_formSubdivision_ss *}
          {if isset($field->subfields->v)}
            form:
            <i class="fa fa-tag" aria-hidden="true" title="form"></i>
            <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss">{$field->subfields->v}</a>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {* 6500_Topic_authorityRecordControlNumber_ss *}
          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="650v_Topic_formSubdivision_ss">{$field->subfields->{'0'}}</a>)
          {/if}
        </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
