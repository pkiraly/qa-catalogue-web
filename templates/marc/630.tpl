{assign var="fieldInstances" value=getFields($record, '630')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>uniform titles</em>:</td>
  <td>
    {foreach $fieldInstances as $field}
      <span class="630">
            {if isset($field->subfields->a)}
              <i class="fa fa-hashtag" aria-hidden="true" title="uniform title"></i>
              <a href="#" class="record-link" data="630a">{$field->subfields->a}</a>
            {/if}

          {if isset($field->subfields->n)}
            <span class="number-of-part" data="630n">{$field->subfields->n}</span>
          {/if}

          {if isset($field->subfields->p)}
            <span class="name-of-part" data="630p">{$field->subfields->p}</span>
          {/if}

          {if isset($field->subfields->l)}
            <span class="language" data="630l">{$field->subfields->l}</span>
          {/if}

          {if isset($field->subfields->d)}
            <span class="dates" data="630d">{$field->subfields->d}</span>
          {/if}

          {if isset($field->subfields->t)}
            <span class="work-title" data="630t">{$field->subfields->t}</span>
          {/if}

          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {if isset($field->subfields->{'0'})}
            (authority: <a href="#" class="record-link" data="6300">{$field->subfields->{'0'}}</a>)
          {/if}
          </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
