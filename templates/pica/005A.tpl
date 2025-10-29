{assign var="fieldInstances" value=$record->getFields('005A')}
{if !is_null($fieldInstances)}
  <tr>
    <td class="record-field-label">ISSN:</td>
    <td>
      {foreach from=$fieldInstances item=field name="fields"}
        {if property_exists($field->subfields, '0')}
          <span class="004A$a">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</span>
        {/if}
        {if property_exists($field->subfields, 'l')}
          <em class="subfield-label">{_t('ISSN-L')}:</em> <span class="004A$m">{include 'data/subfield.tpl' value=$field->subfields->{'l'}}</span>
        {/if}
        {if property_exists($field->subfields, 'm')}
          <em class="subfield-label">{_t('gelöschte ISSN-L')}:</em> <span class="004A$m">{include 'data/subfield.tpl' value=$field->subfields->{'m'}}</span>
        {/if}
        {if property_exists($field->subfields, 'f')}
          <em class="subfield-label">{_t('Kommentar zur ISSN, Einbandart, Lieferbedingungen und/oder Preis')}:</em> <span class="004A$f">{include 'data/subfield.tpl' value=$field->subfields->{'f'}}</span>
        {/if}
        {if !$smarty.foreach.fields.last}<br />{/if}
      {/foreach}
    </td>
  </tr>
{/if}
