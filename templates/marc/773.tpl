{* Host Item Entry, https://www.loc.gov/marc/bibliographic/bd773.html *}
{assign var="fieldInstances" value=$record->getFields('773')}
{if !is_null($fieldInstances)}
  <p>
    Host Item{if count($fieldInstances) > 1}s{/if}:
    {foreach from=$fieldInstances item=field name="fields"}
      <span class="773">
        {if isset($field->subfields->i)}
          <span class="relationship-information" title="Relationship information">{include 'data/subfield.tpl' value=$field->subfields->i}</span>,
        {/if}
        {if isset($field->subfields->s)}
          <span class="" title="Uniform title">{include 'data/subfield.tpl' value=$field->subfields->s}</span>,
        {/if}
        {if isset($field->subfields->t)}
          <span class="title" title="Title">{include 'data/subfield.tpl' value=$field->subfields->t}</span>,
        {/if}
        {if isset($field->subfields->a)}
          <span class="main-entry" title="Main entry heading"><em>{include 'data/subfield.tpl' value=$field->subfields->a}</em></span>,
        {/if}
        {if isset($field->subfields->b)}
          <span class="edition" title="Edition">{include 'data/subfield.tpl' value=$field->subfields->b}</span>,
        {/if}
        {if isset($field->subfields->d)}
          <span class="place-publisher-dates" title="Place, publisher, and date of publication">{include 'data/subfield.tpl' value=$field->subfields->d}</span>,
        {/if}
        {if isset($field->subfields->g)}
          <span class="related-parts" title="Related parts">{include 'data/subfield.tpl' value=$field->subfields->g}</span>,
        {/if}
        {if isset($field->subfields->h)}
          <span class="physical-description" title="Physical description">{include 'data/subfield.tpl' value=$field->subfields->h}</span>,
        {/if}
        {if isset($field->subfields->k)}
          <span class="series-data" title="Series data for related">{include 'data/subfield.tpl' value=$field->subfields->k}</span>,
        {/if}
        {if isset($field->subfields->m)}
          <span class="" title="Material-specific details">{include 'data/subfield.tpl' value=$field->subfields->m}</span>,
        {/if}
        {if isset($field->subfields->n)}
          <span class="" title="Note">{include 'data/subfield.tpl' value=$field->subfields->n}</span>,
        {/if}
        {if isset($field->subfields->o)}
          <span class="" title="Other item identifier">{include 'data/subfield.tpl' value=$field->subfields->o}</span>,
        {/if}
        {if isset($field->subfields->p)}
          <span class="" title="Abbreviated title">{include 'data/subfield.tpl' value=$field->subfields->p}</span>,
        {/if}
        {if isset($field->subfields->q)}
          <span class="" title="Enumeration and first page">{include 'data/subfield.tpl' value=$field->subfields->q}</span>,
        {/if}
        {if isset($field->subfields->r)}
          <span class="" title="Report number">{include 'data/subfield.tpl' value=$field->subfields->r}</span>,
        {/if}
        {if isset($field->subfields->u)}
          <span class="title" title="Standard Technical Report Number">{include 'data/subfield.tpl' value=$field->subfields->u}</span>,
        {/if}
        {if isset($field->subfields->x)}
          ISSN: <span class="issn" title="International Standard Serial Number">{include 'data/subfield.tpl' value=$field->subfields->x}</span>,
        {/if}
        {if isset($field->subfields->y)}
          CODEN: <span class="title" title="CODEN designation">{include 'data/subfield.tpl' value=$field->subfields->y}</span>,
        {/if}
        {if isset($field->subfields->z)}
          ISBN: <span class="ISBN" title="International Standard Book Number">{include 'data/subfield.tpl' value=$field->subfields->z}</span>,
        {/if}
        {if property_exists($field->subfields, '3')}
          <span class="" title="Materials specified">{include 'data/subfield.tpl' value=$field->subfields->{'3'}}</span>,
        {/if}
        {if property_exists($field->subfields, '4')}
          <span class="" title="Relationship">{include 'data/subfield.tpl' value=$field->subfields->{'4'}}</span>,
        {/if}
        {if property_exists($field->subfields, '6')}
          <span class="" title="Linkage">{include 'data/subfield.tpl' value=$field->subfields->{'6'}}</span>,
        {/if}
        {if property_exists($field->subfields, '7')}
          <span class="" title="Control subfield">{include 'data/subfield.tpl' value=$field->subfields->{'7'}}</span>,
        {/if}
        {if property_exists($field->subfields, '8')}
          <span class="" title="Field link and sequence number">{include 'data/subfield.tpl' value=$field->subfields->{'8'}}</span>,
        {/if}
        {if isset($field->subfields->w)}
          <span class="record-control-number">
            {if is_array($field->subfields->w)}
              {foreach from=array_unique($field->subfields->w) item=w name=w}
                <a href="{$record->link($controller->getSolrField('035', 'a'), $w)}"
                 class="record-link">{include 'data/subfield.tpl' value=$w}</a>{if !$smarty.foreach.w.last}, {/if}
              {/foreach}
            {else}
              <a href="{$record->link($controller->getSolrField('035', 'a'), $field->subfields->w)}"
                 class="record-link">{include 'data/subfield.tpl' value=$field->subfields->w}</a>
            {/if}
          </span>
        {/if}
      </span>
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  <p>
{/if}
