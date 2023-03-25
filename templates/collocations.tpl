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
        {include 'common/field-selector.tpl' id="facet1" name="facet1Name" fieldLabel=_('field #1')
                                                   idValue="$facet1" labelValue="$label1"}
        {include 'common/field-selector.tpl' id="facet2" name="facet2Name" fieldLabel=_('field #2')
                                                   idValue="$facet2" labelValue="$label2"}
        <p>
          <button type="submit" class="btn">
           <i class="fa fa-search" aria-hidden="true"></i> {_('Term list')}
          </button>
        </p>
      </form>

      {if isset($results) && !empty($results)}
        <table width="100%">
          <thead>
            <th>{$label1}</th>
            <th>{$label2}</th>
            <th class="text-right">count</th>
          </thead>
          <tbody>
            {foreach from=$results item=result}
              <tr>
                <td>{if preg_match('/(^\s|\s$)/', $result[0])}"{$result[0]}"{else}{$result[0]}{/if}</td>
                <td>{if preg_match('/(^\s|\s$)/', $result[1])}"{$result[1]}"{else}{$result[1]}{/if}</td>
                <td class="float-right"><a href="{$result[3]}">{number_format($result[2])}</a></td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      {/if}

    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}