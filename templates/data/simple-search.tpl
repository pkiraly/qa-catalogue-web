<form id="search">
  <input type="hidden" name="tab" value="data">
  <input type="text" name="query" id="query" value="{htmlentities($query)}" size="60">
  <button type="submit" class="btn">
    <i class="fa fa-search" aria-hidden="true"></i> {_('search')}
  </button>
</form>
