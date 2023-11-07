{* Subject Added Entry - Chronological Term
   http://www.loc.gov/marc/bibliographic/bd648.html *}
{assign var="fieldInstances" value=$record->getFields('648')}
{if !is_null($fieldInstances)}
  <tr>
    <td><em>chronological terms</em>:</td>
    <td>
      {foreach from=$fieldInstances item=field}
        <span class="648">
          {if isset($field->subfields->a)}
            <i class="fa fa-hashtag" aria-hidden="true" title="Chronological term"></i>
            <a href="{$record->filter('648a_ChronologicalSubject_ss', $field->subfields->a)}"
               class="record-link" title="Chronological term">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
          {/if}

          {if isset($field->subfields->v)}
            <span class="dates" title="Form subdivision">{include 'data/subfield.tpl' value=$field->subfields->v}</span>
          {/if}

          {if isset($field->subfields->x)}
            <span class="work-title" title="General subdivision">{include 'data/subfield.tpl' value=$field->subfields->x}</span>
          {/if}

          {if isset($field->subfields->y)}
            <span class="work-title" title="Chronological subdivision">{include 'data/subfield.tpl' value=$field->subfields->y}</span>
          {/if}

          {if isset($field->subfields->z)}
            <span class="work-title" title="Geographic subdivision">{include 'data/subfield.tpl' value=$field->subfields->z}</span>
          {/if}

          {if property_exists($field->subfields, '2') || property_exists(include 'data/subfield.tpl' value=$field->subfields, '0')}[
            {* 6482_ChronologicalSubject_source_ss *}
            {if property_exists($field->subfields, '2')}
              vocabulary: {include 'data/subfield.tpl' value=$field->subfields->{'2'}}</a>
            {/if}

            {if property_exists($field->subfields, '0')}
              (ID: <a href="{$record->filter('6470', $field->subfields->{'0'})}" class="record-link">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</a>)
            {/if}
          ]{/if}
      </span>
          <br/>
        {/foreach}
    </td>
  </tr>
{/if}
