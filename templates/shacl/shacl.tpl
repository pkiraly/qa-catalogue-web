{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="issues" role="tabpanel" aria-labelledby="issues-tab">
      <h2>{_('Custom validation')}</h2>

      <p class="metric-definition">
        {_('shacl_definition')}<br/>
        ({_('Download the custom ruleset')}: <a href="?tab=download&action=download&file={$schemaFile}">{$schemaFile}</a>.)
      </p>

      <table>
        <thead>
          <tr>
            <th colspan="3"></th>
            <th colspan="3" class="text-center" style="padding: 0 10px 0 50px;">number of records</th>
          </tr>
          <tr>
            <th class="text-center" style="padding-right: 10px;">id</th>
            <th class="text-center" style="padding-right: 5px;">criteria</th>
            <th></th>
            <th class="text-center" style="padding: 0 10px 0 50px;">failed</th>
            <th class="text-center" style="padding: 0 10px 0 10px;">passed</th>
            <th class="text-center" style="padding: 0 10px 0 10px;">NA</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$result key=id item=row name=files}
            <tr>
              <td class="text-left" style="padding-right: 10px;">{$id}</td>
              <td class="text-left" style="padding-right: 10px;">
                {if isset($index[$id])}
                  {foreach from=$index[$id] key=name item=criterium name=criteria}
                    {$name}={$criterium}{if !$smarty.foreach.criteria.last},{/if}
                  {/foreach}
                {/if}
              </td>
              <td>
                <div style="float: left; background-color: #9B410E; width:{floor($row->{'0'} * 300 / $count)}px;">&nbsp;</div>
                <div style="float: left; background-color: #37ba00; width:{floor($row->{'1'} * 300 / $count)}px;">&nbsp;</div>
                <div style="float: left; background-color: #cccccc; width:{floor($row->{'NA'} * 300 / $count)}px;">&nbsp;</div>
              </td>
              <td class="text-right">{if $row->{'0'} == 0}0{else}<a href="?tab=data&type=custom-rule&query={$id}:0">{number_format($row->{'0'})}</a>{/if}</td>
              <td class="text-right">{if $row->{'1'} == 0}0{else}<a href="?tab=data&type=custom-rule&query={$id}:1">{number_format($row->{'1'})}</a>{/if}</td>
              <td class="text-right">{if $row->{'NA'} == 0}0{else}<a href="?tab=data&type=custom-rule&query={$id}:NA">{number_format($row->{'NA'})}</a>{/if}</td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
