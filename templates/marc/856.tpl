{* Electronic Location and Access, https://www.loc.gov/marc/bibliographic/bd856.html *}
{assign var="fieldInstances" value=$record->getFields('856')}
{if !is_null($fieldInstances)}
  <p>
    {foreach $fieldInstances as $field name="fields"}
      <span class="856">
        {if isset($field->subfields->{'3'})}
          <span class="" title="Materials specified">{$field->subfields->{'3'}}</span>:
        {/if}
        {if isset($field->subfields->u)}
          <span class="" title="Link">
            <a href="{$field->subfields->u}" target="_blank">
              {if isset($field->subfields->y)}{$field->subfields->y}{else}{$field->subfields->u}{/if}
            </a>
          </span>
        {/if}
        {if isset($field->subfields->q)}
          (<em>format:</em> <span class="" title="Electronic format type">{$field->subfields->q}</span>)
        {/if}
        {if isset($field->subfields->a)}
          <span class="host-name" title="Host name"><em>{$field->subfields->a}</em></span>,
        {/if}
        {if isset($field->subfields->c)}
          <span class="" title="Compression information">{$field->subfields->c}</span>,
        {/if}
        {if isset($field->subfields->d)}
          <span class="" title="Path">{$field->subfields->d}</span>,
        {/if}
        {if isset($field->subfields->f)}
          <span class="" title="Electronic name">{$field->subfields->f}</span>,
        {/if}
        {if isset($field->subfields->m)}
          <em>contact:</em> <span class="" title="Contact for access assistance">{$field->subfields->m}</span>,
        {/if}
        {if isset($field->subfields->o)}
          <span class="" title="Operating system">{$field->subfields->o}</span>,
        {/if}
        {if isset($field->subfields->p)}
          <span class="" title="Port">{$field->subfields->p}</span>,
        {/if}
        {if isset($field->subfields->s)}
          <span class="" title="File size">{$field->subfields->s}</span>,
        {/if}
        {if isset($field->subfields->v)}
          <span class="title" title="Hours access method available">{$field->subfields->v}</span>,
        {/if}
        {if isset($field->subfields->x)}
          <em>Nonpublic note:</em> <span class="" title="Nonpublic note">{$field->subfields->x}</span>,
        {/if}
        {if isset($field->subfields->z)}
          <em>Public note:</em> <span class="" title="Public note">{$field->subfields->z}</span>,
        {/if}
        {if isset($field->subfields->{'2'})}
          <span class="" title="Access method">{$field->subfields->{'2'}}</span>,
        {/if}
        {if isset($field->subfields->{'6'})}
          <span class="" title="Linkage">{$field->subfields->{'6'}}</span>,
        {/if}
        {if isset($field->subfields->{'7'})}
          <span class="" title="Control subfield">{$field->subfields->{'7'}}</span>,
        {/if}
        {if isset($field->subfields->{'8'})}
          <span class="" title="Field link and sequence number">{$field->subfields->{'8'}}</span>,
        {/if}
        {if isset($field->subfields->w)}
          <span class="record-control-number" title="Record control number">
            <a href="{$record->link($controller->getSolrField('035', 'a'), $field->subfields->w)}"
               class="record-link">{$field->subfields->w}</a>
          </span>
        {/if}
      </span>
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  <p>
{/if}
