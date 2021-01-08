{* Subject Added Entry - Named Event, https://www.loc.gov/marc/bibliographic/bd647.html *}
{assign var="fieldInstances" value=$record->getFields('647')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>named events</em>:</td>
  <td>
    {foreach $fieldInstances as $field}
      <span class="647">
        {if isset($field->subfields->a)}
          <i class="fa fa-hashtag" aria-hidden="true" title="Named event"></i>
          <a href="{$record->filter('647a', $field->subfields->a)}" class="record-link" title="Named event">{$field->subfields->a}</a>
        {/if}

        {if isset($field->subfields->c)}
          <span class="number-of-part" title="Location of named event">{$field->subfields->c}</span>
        {/if}

        {if isset($field->subfields->d)}
          <span class="name-of-part" title="Date of named event">{$field->subfields->d}</span>
        {/if}

        {if isset($field->subfields->g)}
          <span class="language" title="Miscellaneous information">{$field->subfields->g}</span>
        {/if}

        {if isset($field->subfields->v)}
          <span class="dates" title="Form subdivision">{$field->subfields->v}</span>
        {/if}

        {if isset($field->subfields->x)}
          <span class="work-title" title="General subdivision">{$field->subfields->x}</span>
        {/if}

        {if isset($field->subfields->y)}
          <span class="work-title" title="Chronological subdivision">{$field->subfields->y}</span>
        {/if}

        {if isset($field->subfields->z)}
          <span class="work-title" title="Geographic subdivision">{$field->subfields->z}</span>
        {/if}

        {if isset($field->subfields->{'2'}) || isset($field->subfields->{'0'})}[
          {if isset($field->subfields->{'2'})}
            vocabulary: {$field->subfields->{'2'}}</a>
          {/if}

          {if isset($field->subfields->{'0'})}
            (authority: <a href="{$record->filter('6470', $field->subfields->{'0'})}" class="record-link">{$field->subfields->{'0'}}</a>)
          {/if}
        ]{/if}
      </span>
      <br/>
    {/foreach}
  </td>
</tr>
{/if}
