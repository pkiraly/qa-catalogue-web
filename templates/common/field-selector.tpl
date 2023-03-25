<p>
  <input name="facet" id="facet" onchange="this.form.submit()" type="hidden" value="{$facet}">
  <label for="facetName">{_('Field')}:</label>
  <input id="facetName" value="{$label}" size="80">
</p>
<script>
$(function() {
  $("#facetName").autocomplete({
    source: '?tab=terms&action=fields',
    select: function(event, ui) {
      $("#facetName").val(ui.item.label);
      $("#facet").val(ui.item.value);
      return false;
    },
    focus: function(event, ui) {
      $("#facetName").val(ui.item.label);
      $("#facet").val(ui.item.value);
      return false;
    },
  });
});
</script>
