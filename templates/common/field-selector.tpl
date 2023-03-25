{*
  $id
  $name
  $fieldLabel
  $idValue -- $facet
  $labelValue -- $label
  $size = 80
*}
{assign var='fieldLabel' value=$fieldLabel|default:_('Field')}
{assign var='size' value=$size|default:'80'}
<p>
  <input name="{$id}" id="{$id}" onchange="this.form.submit()" type="hidden" value="{$idValue}">
  <label for="{$name}">{$fieldLabel}:</label>
  <input id="{$name}" value="{$labelValue}" size="{$size}">
</p>
<script>
$(function() {
  $("#{$name}").autocomplete({
    source: '?tab=terms&action=fields',
    select: function(event, ui) {
      $("#{$name}").val(ui.item.label);
      $("#{$id}").val(ui.item.value);
      return false;
    },
    focus: function(event, ui) {
      $("#{$name}").val(ui.item.label);
      $("#{$id}").val(ui.item.value);
      return false;
    },
  });
});
</script>
