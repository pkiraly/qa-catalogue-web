{* Series Statement
   http://www.loc.gov/marc/bibliographic/bd490.html *}
{assign var="fieldInstances" value=getFields($record, '490')}
{if !is_null($fieldInstances)}
  Series:
    <ul>
  {foreach $fieldInstances as $field}
    <li>
    {if isset($field->subfields->a)}
      {foreach $field->subfields->a as $value}
        <a href="#" class="record-link tag-490a" data="490a_SeriesStatement_ss"
          title="Series statement">{$value}</a>{if !$value@last}, {/if}
      {/foreach}
    {/if}

    {if isset($field->subfields->l)}
      <span class="subarea" data="490l"
         title="Library of Congress call number">{$field->subfields->l}</span>
    {/if}

    {if isset($field->subfields->v)}
      <a href="#" class="subarea" data="490v_SeriesStatement_volume_ss"
         title="Volume/sequential designation">{$field->subfields->v}</a>
    {/if}

    {if isset($field->subfields->x)}
      <span class="issn" data="490x"
         title="International Standard Serial Number">{$field->subfields->x}</span>
    {/if}

    {if isset($field->subfields->{'3'})}
      <a href="#" class="issn" data="4903_SeriesStatement_materialsSpecified_ss"
         title="Materials specified">{$field->subfields->{'3'}}</a>
    {/if}
    </li>
  {/foreach}
  </ul>
{/if}
