<p class="library-selector">
  <input name="groupId" id="groupId" onchange="this.form.submit()" type="hidden" value="{$groupId}">
  <label for="groupName">{_('Library')}:</label>
  <input id="groupName" value="{$currentGroup->group}" size="80">
</p>
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
