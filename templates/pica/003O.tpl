{assign var="fieldInstances" value=$record->getFields('003O')}
{if !is_null($fieldInstances)}
<tr>
  <td class="record-field-label">Sonstige Nummern:</td>
  <td>
    {foreach from=$fieldInstances item=field name="fields"}
      {if isset($field->subfields->a)}<span class="003O$a">{include 'data/subfield.tpl' value=$field->subfields->a}</span>:{/if}
      {if property_exists($field->subfields, '0')}
        {if isset($field->subfields->a) && $field->subfields->a == 'OCoLC'}
          <a href="http://www.worldcat.org/oclc/{$field->subfields->{'0'}}"><span class="003O$0">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</span></a>
          <img src="https://icoswb.bsz-bw.de/psi/img_psi/2.0/seealso/worldcat_2.jpg">
        {else}
          <span class="003O$0">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</span>
        {/if}
      {/if}
      {if !$smarty.foreach.fields.last}<br/>{/if}
    {/foreach}
  </td>
</tr>
{/if}
