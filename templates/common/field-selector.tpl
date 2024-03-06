{*
variables:
  $id - the "field id" input form element's name (e.g. 'facet')
  $name - the autocomplete "field" input form element's name (e.g. 'facetName')
  $idValue - the default value of the "field id" input form element
  $labelValue - the default value of the "field" input form element
  $fieldLabel - the label for the input (default value: 'Field')
  $size - the size of the autocomplete "field" input (default value: 80)
  $display - whether the snippet should be displayed in a block (with p) or inline (with span) (default value: 'block')
  $variant - use which field variant the 'phrase' or 'tokenized' (default value: 'phrase')
*}
{assign var='idValue' value=$idValue|default:''}
{assign var='labelValue' value=$labelValue|default:''}
{assign var='fieldLabel' value=$fieldLabel|default:_('Field')}
{assign var='size' value=$size|default:80}
{assign var='display' value=$display|default:block}
{assign var='variant' value=$variant|default:'phrase'}
{if $display == 'inline'}<span>{else}<p>{/if}
  <input name="{$id}" id="{$id}" onchange="this.form.submit()" type="hidden" value="{$idValue}">
  <label for="{$name}">{$fieldLabel}:</label>
  <input id="{$name}" value="{$labelValue}" size="{$size}">
{if $display == 'inline'}</span>{else}</p>{/if}
<script>
$(function() {
  $("#{$name}").autocomplete({
    source: '?tab=terms&action=fields&variant={$variant}',
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
