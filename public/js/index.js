$(document).ready(function () {
  showRecordDetails();
});

function showRecordDetails() {
  $('.record h2 a.record-details').click(function (event) {
    event.preventDefault();
    var detailsId = $(this).attr('data');
    console.log(detailsId);
    $('#' + detailsId).toggle();
    $('#' + detailsId + ' a[aria-controls="marc-human-tab"]').click(function (e) {
      showDataTab(detailsId, 'marc-human');
    });
    $('#' + detailsId + ' a[aria-controls="marc-issue-tab"]').click(function (e) {
      showDataTab(detailsId, 'marc-issue');
    });
  });

  $('.record-link').click(function (event) {
    event.preventDefault();
    var field = $(this).attr('data');
    var value = $(this).html();
    var filterParam = filterParamTemplate({'field': field, 'value': value});
    filters.push({
      'param': filterParam,
      'label': getFacetLabel(field) + ': ' + value
    });
    start = 0;
    loadDataTab(buildUrl());
  });
}

function showDataTab(detailsId, selectedTab) {
  console.log(detailsId)
  var id = detailsId.replace('details-', '');
  console.log(id)
  var tabs = ['marc-raw', 'marc-human', 'marc-issue'];
  for (i in tabs) {
    var tab = tabs[i];
    console.log(tab + ' -> ' + '#' + tab + '-' + id)

    if (tab == selectedTab) {
      $('#' + tab + '-' + id).addClass('active');
      $('#' + tab + '-' + id).show();
    } else {
      $('#' + tab + '-' + id).removeClass('active');
      $('#' + tab + '-' + id).hide();
    }
    console.log($('#' + tab + '-' + id).classList());
  }
}