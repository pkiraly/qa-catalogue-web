{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="issues" role="tabpanel" aria-labelledby="issues-tab">
      <h2>{_('Translation analysis')}</h2>

      <p class="metric-definition">
        {_('shacl_definition')}<br/>
        ({_('Download the custom ruleset')}: <a href="?tab=download&action=download&file={$schemaFile}">{$schemaFile}</a>.)
      </p>

      <table>
        <thead>
          <tr>
            <th colspan="3"></th>
            <th colspan="6" class="text-center" style="padding: 0 10px 0 50px;">number of records</th>
          </tr>
          <tr>
            <th class="text-center" style="padding-right: 10px;">path</th>
            <th class="text-center" style="padding-right: 5px;">criteria</th>
            <th></th>
            <th class="text-center" style="padding: 0 10px 0 50px;" colspan="2">failed</th>
            <th class="text-center" style="padding: 0 10px 0 10px;" colspan="2">passed</th>
            <th class="text-center" style="padding: 0 10px 0 10px;" colspan="2">NA</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$result key=id item=row name=files}
            <tr>
              <td class="text-left" style="padding-right: 10px;">{if isset($index[$id])}{$index[$id]['path']}{else}{$id}{/if}</td>
              <td class="text-left" style="padding-right: 10px;">
                {if isset($index[$id])}
                  {foreach from=$index[$id] key=name item=criterium name=criteria}
                    {if $name != 'path'}
                      {if $name == 'description'}
                        <em>{$criterium}</em><br/>
                      {else}
                        {if is_array($criterium)}{$controller->showArray($name, $criterium)}{else}{$name}={$criterium}{/if}{if !$smarty.foreach.criteria.last},{/if}
                      {/if}
                    {/if}
                  {/foreach}
                {/if}
              </td>
              <td>
                <div style="float: left; background-color: #9B410E; width:{floor($row->{'0'} * 300 / $count)}px;">&nbsp;</div>
                <div style="float: left; background-color: #37ba00; width:{floor($row->{'1'} * 300 / $count)}px;">&nbsp;</div>
                <div style="float: left; background-color: #cccccc; width:{floor($row->{'NA'} * 300 / $count)}px;">&nbsp;</div>
              </td>
              <td class="text-right" style="min-width: 100px;">
                {if $row->{'0'} == 0}
                  0
                {else}
                  {number_format($row->{'0'})}
                {/if}
              </td>
              <td style="min-width: 60px;">
                {if $row->{'0'} > 0}
                  <a href="{$controller->queryUrl($id, 0)}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
                  <a href="{$controller->downloadUrl($id, 0)}" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
                {/if}
              </td>
              <td class="text-right">
                {if $row->{'1'} == 0}
                  0
                {else}
                  {number_format($row->{'1'})}
                {/if}
              </td>
              <td style="min-width: 60px;">
                {if $row->{'1'} > 0}
                  <a href="{$controller->queryUrl($id, 1)}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
                  <a href="{$controller->downloadUrl($id, 1)}" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
                {/if}
              </td>
              <td class="text-right">
                {if $row->{'NA'} == 0}
                  0
                {else}
                  {number_format($row->{'NA'})}</a>
                {/if}
              </td>
              <td style="min-width: 60px;">
                {if $row->{'NA'} > 0}
                  <a href="{$controller->queryUrl($id, 'NA')}" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
                  <a href="{$controller->downloadUrl($id, 'NA')}" class="list"><i class="fa fa-download" aria-hidden="true"></i></a>
                {/if}
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}
