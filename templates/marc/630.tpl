{assign var="fieldInstances" value=$record->getFields('630')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uniform titles</em>:</td>
  <td>
    {foreach from=$fieldInstances item=field}
      <span class="630">
        {if isset($field->subfields->a)}
          <i class="fa fa-hashtag" aria-hidden="true" title="uniform title"></i>
          <a href="{$record->filter('630a_SubjectAddedUniformTitle_ss', $field->subfields->a)}" class="record-link">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
        {/if}

        {if isset($field->subfields->n)}
          <span class="number-of-part" data="630n_SubjectAddedUniformTitle_numberOfPart_ss">{include 'data/subfield.tpl' value=$field->subfields->n}</span>
        {/if}

        {if isset($field->subfields->p)}
          <span class="name-of-part" data="630p_SubjectAddedUniformTitle_nameOfPart_ss">{include 'data/subfield.tpl' value=$field->subfields->p}</span>
        {/if}

        {if isset($field->subfields->l)}
          <span class="language" data="630l_SubjectAddedUniformTitle_languageOfAWork_ss">{include 'data/subfield.tpl' value=$field->subfields->l}</span>
        {/if}

        {if isset($field->subfields->d)}
          <span class="dates" data="630d_SubjectAddedUniformTitle_dateOfTreaty_ss">{include 'data/subfield.tpl' value=$field->subfields->d}</span>
        {/if}

        {if isset($field->subfields->t)}
          <span class="work-title" data="630t_SubjectAddedUniformTitle_titleOfAWork_ss">{include 'data/subfield.tpl' value=$field->subfields->t}</span>
        {/if}

        {if property_exists($field->subfields, '2')}
          vocabulary: {include 'data/subfield.tpl' value=$field->subfields->{'2'}}</a>
        {/if}

        {if property_exists($field->subfields, '0')}
          (authority: <a href="{$record->filter('6300', $field->subfields->{'0'})}" class="record-link">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</a>)
        {/if}
      </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
