{* Geographic Classification
   http://www.loc.gov/marc/bibliographic/bd052.html *}
{assign var="fieldInstances" value=$record->getFields('052')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>geographic classification</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="052">
      {*  Subject category code *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="Geographic classification area code"></i>
        <a href="#" class="area" data="052a"
           title="Geographic classification area code">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="#" class="subarea" data="052b"
           title="Geographic classification subarea code">{include 'data/subfield.tpl' value=$field->subfields->b}</a>
      {/if}

      {if isset($field->subfields->d)}
        <a href="#" class="place-name" data="052d"
           title="Populated place name">{include 'data/subfield.tpl' value=$field->subfields->d}</a>
      {/if}

      {if property_exists($field->subfields, '2')}
        <a href="#" class="source" data="0522" title="Source">{include 'data/subfield.tpl' value=$field->subfields->{'2'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
