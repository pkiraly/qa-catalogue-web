{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>{_('Collocation of field values')}</h2>

      <p class="metric-definition">
        {_('collocations_definition')}
      </p>
        <form id="facetselection">
          <input type="hidden" name="tab" value="collocations" />
          <table>
            <tr>
              <td>
                  {_('field #1')} <input list="facet1" name="facet1" id="facetInput1" style="width: 300px;"
                              value="{if isset($facet1) && !empty($facet1)}{$facet1}{else}- select a field! -{/if}">
                <datalist id="facet1">
                  {foreach from=$solrFields item=field}
                    <option value="{$field}"{if $field == $facet1} selected="selected"{/if}>{$field}</option>
                  {/foreach}
                </datalist>
              </td>
              <td>
                  {_('field #2')} <input list="facet2" name="facet2" id="facetInput2" style="width: 300px;"
                              value="{if isset($facet2) && !empty($facet2)}{$facet2}{else}- select a field! -{/if}">
                <datalist id="facet2">
                  {foreach from=$solrFields item=field}
                    <option value="{$field}"{if $field == $facet2} selected="selected"{/if}>{$field}</option>
                  {/foreach}
                </datalist>
              </td>
              <td>
                <button type="submit" class="btn">
                  <i class="fa fa-search" aria-hidden="true"></i> {_('Term list')}
                </button>
              </td>
            </tr>
          </table>
        </form>

      {if isset($results) && !empty($results)}
        <table>
          {foreach from=$results item=result}
            <tr>
              <td>{if preg_match('/(^\s|\s$)/', $result[0])}"{$result[0]}"{else}{$result[0]}{/if}</td>
              <td>{if preg_match('/(^\s|\s$)/', $result[1])}"{$result[1]}"{else}{$result[1]}{/if}</td>
              <td class="float-right"><a href="{$result[3]}">{number_format($result[2])}</a></td>
            </tr>
          {/foreach}
        </table>
      {/if}

    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}