<h3>records with authority names</h3>

<div class="row" style="width: 500px; margin: 0 0 0 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    <span style="color: #37ba00">{_('with')}</span>
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    <span style="color: maroon">{_('without')}</span>
  </div>
</div>

<div style="width: 500px; background-color: maroon">
  <div style="width: {ceil($withClassification->percent * 500)}px; background-color: #37ba00; height: 10px;">&nbsp;</div>
</div>

<div class="row" style="width: 500px; margin: 0 0 20px 0">
  <div class="col-sm" style="margin: 0; padding: 0">
    {$withClassification->count|number_format:0}
    ({($withClassification->percent * 100)|number_format:2}%)
  </div>
  <div class="col-sm text-right" style="margin: 0; padding: 0">
    {$withoutClassification->count|number_format:0}
    ({($withoutClassification->percent * 100)|number_format:2}%)
  </div>
</div>
