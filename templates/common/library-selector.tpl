<p class="library-selector" style="margin: 0;">
  <input name="groupId" id="groupId" type="hidden" value="{$groupId}">
  <label for="groupName" class="form-label">{_('Library')}:</label>
  <input id="groupName" value="{$currentGroup->group}" type="text"
         class="form-control" size="50" style="display: inline; width: 65%">
  <button type="submit" class="btn">
    <i class="fa fa-search" aria-hidden="true"></i> {_t('Select')}
  </button>
  <button class="btn btn-secondary" id="group-reset">
    {_t('the whole catalogue')}
  </button>
</p>
<script>
{literal}
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
    $('#group-reset').on('click', function(e) {
      $("#groupName").val('');
      $("#groupId").val('');
      // e.preventDefault(); // do not submit the form
    });
  });
{/literal}
</script>