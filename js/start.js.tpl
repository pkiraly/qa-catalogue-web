const obj = JSON.parse("{$fields|escape:javascript}");
const shelf_ready_data = JSON.parse("{$shelf_ready_completeness|escape:javascript}");

const issuesGraphContext = document.getElementById('issuesGraph');
new Chart(issuesGraphContext, {
    type: 'doughnut',
    data: {
        labels: ['Without issues', 'With undefined fields', 'With issues'],
        datasets: [{
            label: '# of Records',
            data: ['{$issueStats->summary->good|escape:javascript}', '{$issueStats->summary->unclear|escape:javascript}', '{$issueStats->summary->bad|escape:javascript}'],
            backgroundColor: ["#37ba00", "#FFFF00", "#FF4136"],
            borderWidth: 1
        }]
    },
    options: {
      responsive: true
    }
});

const authoritiesNameGraphContext = document.getElementById('authoritiesNameGraph');
new Chart(authoritiesNameGraphContext, {
    type: 'doughnut',
    data: {
        labels: ['Without authority name', 'With authority name'],
        datasets: [{
            label: '# of Records',
            data: ['{$authorities->withClassification->count|escape:javascript}', '{$authorities->withoutClassification->count|escape:javascript}'],
            backgroundColor: ["#37ba00", "#FF4136"],
            borderWidth: 1
        }]
    },
    options: {
      responsive: true
    }
});

const authoritiesGraphContext = document.getElementById('authoritiesGraph');
new Chart(authoritiesGraphContext, {
    type: 'doughnut',
    data: {
        labels: ['Without authorities', 'With authorities'],
        datasets: [{
            label: '# of Records',
            data: ['{$classifications->withClassification->count|escape:javascript}', '{$classifications->withoutClassification->count|escape:javascript}'],
            backgroundColor: ["#37ba00", "#FF4136"],
            borderWidth: 1
        }]
    },
    options: {
      responsive: true
    }
});


const completensGraphContext = document.getElementById('completenessGraph');


var completenessOptions = {
  container: completensGraphContext,
  data: [],
  series: [
    {
      type: 'bar',
      xKey: 'label',
      yKey: 'Completeness',
      fill: "#37ba00",
      stroke: "green",
      highlightStyle: {
        item: {
          fill: 'green'
        },
      },
      listeners: {
        nodeClick: onCompletenessClicked,
      },
    },
  ],
};

var completenessChart = agCharts.AgChart.create(completenessOptions);

updateCompletenessContent(0, "", "");

document.getElementById("completenessBack").addEventListener('click', onCompletenessBack);


function onCompletenessClicked(event) {
  const datum = event.datum;
  if (datum.level < 2 && datum.level >= 0) {
    updateCompletenessContent(datum.level + 1, datum.packageName, datum.label);
  }
}

function onCompletenessBack() {
  const level = completenessOptions.data[0].level
  const packageName = completenessOptions.data[0].packageName

  if (level <= 2 && level > 0) {
    updateCompletenessContent(level - 1, packageName, "");
  }
}

function updateCompletenessContent(level, packageName, label) {

  var tree = null;

  switch(level) {
    case 0:
      tree = Object.entries(obj).map(function(entry) {
              return {
                label: entry[0],
                packageName: entry[0],
                level: 0,
                Completeness: Number(entry[1][""][""].count)
              }
            });
    break;

    case 1:
      
      tree = Object.entries(obj[packageName]).filter(function(entry) { // Remove summary entries
              return entry[0] !== "";
            }).map(function(entry) {
              return {
                label: entry[0],
                packageName: packageName,
                level: 1,
                Completeness: Number(entry[1][""].count)
              }
            })
    break;

    case 2:
      tree = Object.entries(obj[packageName][label]).filter(function(entry) { // Remove summary entries
              return entry[0] !== "";
            }).map(function(entry) {
              return {
                label: entry[0],
                packageName: packageName,
                level: 2,
                Completeness: Number(entry[1].count),
              }
            });
    break;
  }

  tree.sort(
    function(a, b){
      return b.Completeness - a.Completeness
      });
  completenessOptions.data = tree;
  agCharts.AgChart.update(completenessChart, completenessOptions);
}

const boothShelfReadyContext = document.getElementById('boothShelfReady');
{literal}
const boothShelfReady = Object.keys(shelf_ready_data).map((i) => ({"Score": parseFloat(i), "Number of Records": parseInt(shelf_ready_data[i])}));
console.debug(boothShelfReady);
{/literal}

const options = {
  container: boothShelfReadyContext,
  data: boothShelfReady,
  series: [
    {
      type: 'histogram',
      aggregation: 'sum',
      xKey: 'Score',
      yKey: 'Number of Records',
      fill: "#37ba00",
      stroke: "green",
      highlightStyle: {
        item: {
          fill: 'green'
        },
      },
    },
  ],
  axes: [
    {
      type: 'number',
      position: 'bottom',
      title: { text: 'Score' },
    },
    {
      type: 'number',
      position: 'left',
      title: { text: 'No. Records' },
    },
  ],
};

agCharts.AgChart.create(options);

