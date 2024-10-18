{assign var="fieldInstances" value=$record->getFields('080')}
{if !is_null($fieldInstances)}
<tr>
  <td><em>Universal Decimal Classification</em>:</td>
  <td>
  {foreach from=$fieldInstances item=field}
    <span class="080">
      {*  Personal name *}
      {if isset($field->subfields->a)}
        <i class="fa fa-hashtag" aria-hidden="true" title="udc"></i>
        <a href="{$record->filter('080a_Udc_ss', $field->subfields->a)}" class="record-link">{include 'data/subfield.tpl' value=$field->subfields->a}</a>
      {/if}

      {if isset($field->subfields->b)}
        <a href="{$record->filter('080b_Udc_number_ss', $field->subfields->b)}" class="record-link item-number">{include 'data/subfield.tpl' value=$field->subfields->b}</a>
      {/if}

      {*
      {if isset($field->subfields->c)}
        <a href="#" class="record-link item-number" data="080c_Udc_c_ss">{$field->subfields->c}</a>
      {/if}

      {if isset($field->subfields->d)}
        <a href="#" class="record-link item-number" data="080d_Udc_d_ss">{$field->subfields->d}</a>
      {/if}

      {if isset($field->subfields->e)}
        <a href="#" class="record-link item-number" data="080e_Udc_e_ss">{$field->subfields->e}</a>
      {/if}

      {if isset($field->subfields->g)}
        <a href="#" class="record-link item-number" data="080g_Udc_g_ss">{$field->subfields->g}</a>
      {/if}

      {if isset($field->subfields->m)}
        <a href="#" class="record-link item-number" data="080m_Udc_m_ss">{$field->subfields->m}</a>
      {/if}

      {if isset($field->subfields->s)}
        <a href="#" class="record-link item-number" data="080s_Udc_s_ss">{$field->subfields->s}</a>
      {/if}

      {if isset($field->subfields->v)}
        <a href="#" class="record-link item-number" data="080v_Udc_v_ss">{$field->subfields->v}</a>
      {/if}

      {if isset($field->subfields->w)}
        <a href="#" class="record-link item-number" data="080w_Udc_w_ss">{$field->subfields->w}</a>
      {/if}
      *}

      {if isset($field->subfields->x)}
        <a href="{$record->filter('080x_Udc_commonAuxiliarySubdivision_ss', $field->subfields->x)}" class="common-auxiliary-subdivision">{include 'data/subfield.tpl' value=$field->subfields->x}</a>
      {/if}

      {*
      {if isset($field->subfields->z)}
        <a href="#" class="record-link item-number" data="080z_Udc_z_ss">{$field->subfields->z}</a>
      {/if}
      *}
      {if property_exists($field->subfields, '2')}
        <a href="{$record->filter('0802_Udc_edition_ss', $field->subfields->{'2'})}" class="edition">{include 'data/subfield.tpl' value=$field->subfields->{'2'}}</a>
      {/if}

      {if $field->ind1 == '0'}Full{/if}
      {if $field->ind1 == '1'}Abridged{/if}

      {if property_exists($field->subfields, '0')}
        <a href="{$record->filter('0800_Udc_0_ss', $field->subfields->{'0'})}" class="edition">{include 'data/subfield.tpl' value=$field->subfields->{'0'}}</a>
      {/if}
    </span>
    <br/>
  {/foreach}
  </td>
</tr>
{/if}
