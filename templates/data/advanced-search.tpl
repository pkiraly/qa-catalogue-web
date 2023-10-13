<form id="search">
  <input type="hidden" name="tab" value="data">
  <input type="hidden" name="search-form" value="advanced">

  <div class="field-search">
    {include 'common/field-selector.tpl' id="field1" name="fieldName1" idValue="$field1" labelValue=$label1 size=20 display="inline" variant="tokenized"}
    <input type="text" name="value1" id="value1" value="{htmlentities($value1)}" size="40">
  </div>

  <div class="field-search">
    {include 'common/field-selector.tpl' id="field2" name="fieldName2" idValue="$field2" labelValue=$label2 size=20 display="inline" variant="tokenized"}
    <input type="text" name="value2" id="value2" value="{htmlentities($value2)}" size="40">
  </div>

  <div class="field-search">
    {include 'common/field-selector.tpl' id="field3" name="fieldName3" idValue="$field3" labelValue=$label3 size=20 display="inline" variant="tokenized"}
    <input type="text" name="value3" id="value3" value="{htmlentities($value3)}" size="40">
  </div>

  <button type="submit" class="btn">
    <i class="fa fa-search" aria-hidden="true"></i> {_('search')}
  </button>
</form>
