{* Electronic Location and Access, https://www.loc.gov/marc/bibliographic/bd856.html *}
{assign var="fieldInstances" value=$record->getFields('856')}
{if !is_null($fieldInstances)}
  {assign var="count" value="{count($fieldInstances)}"}
  <p>
    {if $count > 1}<em>Links:</em><ul class="list-856">{/if}
    {foreach from=$fieldInstances item=field name="fields"}
      {if $count > 1}<li>{/if}
      <span class="856">
        {if property_exists($field->subfields, '3')}
          <span class="" title="Materials specified">{$field->subfields->{'3'}}</span>:
        {/if}
        {if isset($field->subfields->u)}
          <span class="" title="Link">
            <a href="{$field->subfields->u}" target="_blank">
              {if isset($field->subfields->y)}{include 'data/subfield.tpl' value=$field->subfields->y}{else}{include 'data/subfield.tpl' value=$field->subfields->u}{/if}
            </a>
          </span>
        {/if}
        {if isset($field->subfields->q)}
          (<em>format:</em> <span class="" title="Electronic format type">{include 'data/subfield.tpl' value=$field->subfields->q}</span>)
        {/if}
        {if isset($field->subfields->a)}
          <span class="host-name" title="Host name"><em>{include 'data/subfield.tpl' value=$field->subfields->a}</em></span>,
        {/if}
        {if isset($field->subfields->c)}
          <span class="" title="Compression information">{include 'data/subfield.tpl' value=$field->subfields->c}</span>,
        {/if}
        {if isset($field->subfields->d)}
          <span class="" title="Path">{include 'data/subfield.tpl' value=$field->subfields->d}</span>,
        {/if}
        {if isset($field->subfields->f)}
          <span class="" title="Electronic name">{include 'data/subfield.tpl' value=$field->subfields->f}</span>,
        {/if}
        {if isset($field->subfields->m)}
          <em>contact:</em> <span class="" title="Contact for access assistance">{include 'data/subfield.tpl' value=$field->subfields->m}</span>,
        {/if}
        {if isset($field->subfields->o)}
          <span class="" title="Operating system">{include 'data/subfield.tpl' value=$field->subfields->o}</span>,
        {/if}
        {if isset($field->subfields->p)}
          <span class="" title="Port">{include 'data/subfield.tpl' value=$field->subfields->p}</span>,
        {/if}
        {if isset($field->subfields->s)}
          <span class="" title="File size">{include 'data/subfield.tpl' value=$field->subfields->s}</span>,
        {/if}
        {if isset($field->subfields->v)}
          <span class="title" title="Hours access method available">{include 'data/subfield.tpl' value=$field->subfields->v}</span>,
        {/if}
        {if isset($field->subfields->x)}
          <em>nonpublic note:</em> <span class="" title="Nonpublic note">{include 'data/subfield.tpl' value=$field->subfields->x}</span>,
        {/if}
        {if isset($field->subfields->z)}
          <em>public note:</em> <span class="" title="Public note">{include 'data/subfield.tpl' value=$field->subfields->z}</span>,
        {/if}
        {if property_exists($field->subfields, '2')}
          (<span class="" title="Access method">{include 'data/subfield.tpl' value=$field->subfields->{'2'}}</span>),
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
          <span class="record-control-number" title="Record control number">
            <a href="{$record->link($controller->getSolrField('035', 'a'), $field->subfields->w)}"
               class="record-link">{include 'data/subfield.tpl' value=$field->subfields->w}</a>
          </span>
        {/if}
      </span>
      {if $count > 1}</li>{/if}
    {/foreach}
    {if $count > 1}</ul>{/if}
  <p>
{/if}
