{if $groupped}
  <div id="group-selector">
    <form>
      <input type="hidden" name="tab" value="{$tab}">
      {if isset($params)}
        {foreach from=$params key="key" item="value"}
          {if is_array($value)}
            {foreach from=$value item="v"}
              <input type="hidden" name="{$key}[]" value="{if strstr($v, '"')}{$v|htmlspecialchars}{else}{$v}{/if}">
            {/foreach}
          {else}
            <input type="hidden" name="{$key}" value="{$value}">
          {/if}
        {/foreach}
      {/if}
      <input name="groupId" id="groupId" onchange="this.form.submit()" type="hidden" value="{$groupId}">

      <p>
        <label for="groupName">{_('Library')}</label>
        <input id="groupName" value="{$currentGroup->group}" size="80">
      </p>
    </form>
  </div>
  <script>
    $(function() {
      $("#groupName").autocomplete({
        source: '?tab=completeness&ajax=1&action=ajaxGroups',
        select: function(event, ui) {
          $("#groupName").val(ui.item.label);
          $("#groupId").val(ui.item.value);
          return false;
        },
        focus: function(event, ui) {
          $("#groupName").val(ui.item.label);
          $("#groupId").val(ui.item.value);
          return false;
        },
      });
    });
  </script>
{/if}
