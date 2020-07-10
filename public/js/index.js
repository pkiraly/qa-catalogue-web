$(document).ready(function () {
  showRecordDetails();
});

function showRecordDetails() {
  $('.record h2 a.record-details').click(function (event) {
    event.preventDefault();
    var detailsId = $(this).attr('data');
    console.log('showRecordDetails: ' + detailsId);
    $('#' + detailsId).toggle();
    $('#' + detailsId + ' a[aria-controls="marc-human-tab"]').click(function (e) {
      console.log('click on human tab');
      showDataTab(detailsId, 'marc-human');
    });
    $('#' + detailsId + ' a[aria-controls="marc-issue-tab"]').click(function (e) {
      console.log('click on issue tab');
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
  var id = detailsId.replace('details-', '');
  var tabs = ['marc-raw', 'marc-human', 'marc-issue'];
  for (i in tabs) {
    var tab = tabs[i];
    var tabId = '#' + tab + '-tab-' + id;
    var contentId = '#' + tab + '-' + id;

    if (tab == selectedTab) {
      $(tabId).addClass('active');
      $(contentId).show();
    } else {
      $(tabId).removeClass('active');
      $(contentId).hide();
    }
  }
}