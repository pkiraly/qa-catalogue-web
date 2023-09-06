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


var completeness = new Chart(completensGraphContext, {
  type: 'bar',
  maintainAspectRatio: false,
  data: {
    datasets: [
      {
        label: '# of records',
        key: 'Completeness',
        borderColor: 'green',
        backgroundColor: '#37ba00',
        borderWidth: 1,
        spacing: 0
      }
    ],
  },
  options: {
    indexAxis: 'y',
    interaction: {
      mode: 'index',
      axis: 'y',
      intersect: false,
    },
    plugins: {
      legend: {
        display: false
      },
      tooltip: {
        callbacks: {
          title: args => {
            return args[0].dataset.data[args[0].dataIndex].name;
          }
        },
      },
    },
    scales: {
      y: {
        ticks: {
          autoSkip: false,
        }
      },
      x: {
        ticks: {
          format: {
            notation: "compact",
            compactDisplay: "short",
          }
        }
      }
    },
    onClick: onCompletenessClicked,
    responsive: true,
    ratio: 1,
    parsing: {
      yAxisKey: 'label',
      xAxisKey: 'Completeness'
    },
  }
});

updateCompletenessContent(0, "", "");

document.getElementById("completenessBack").addEventListener('click', onCompletenessBack);


function onCompletenessClicked(event, array) {
  const level = array[0].element.$context.raw.level;
  const packageId = array[0].element.$context.raw.packageId;
  const label = array[0].element.$context.raw.label;

  if (level < 2 && level >= 0 && packageId != '0') {
    updateCompletenessContent(level + 1, packageId, label);
  }
}

function onCompletenessBack() {
  const level = completeness.data.datasets[0].data[0].level
  const packageName = completeness.data.datasets[0].data[0].packageId

  if (level <= 2 && level > 0) {
    updateCompletenessContent(level - 1, packageName, "");
  }
}

function updateCompletenessContent(level, packageId, label) {

  var tree = null;

  switch(level) {
    case 0:
      tree = Object.entries(obj).map(function(entry) {
              return {
                label: entry[0],
                packageId: entry[0],
                level: 0,
                name: entry[0] + ": " + entry[1][""][""].name,
                Completeness: Number(entry[1][""][""].count),
              }
            });
    break;

    case 1:
      
      tree = Object.entries(obj[packageId]).filter(function(entry) { // Remove summary entries
              return entry[0] !== "";
            }).map(function(entry) {
              return {
                label: entry[0],
                packageId: packageId,
                level: 1,
                name: packageId + "-" + entry[0] + ": " + entry[1]["$"].name,
                Completeness: Number(entry[1]["$"].count),
              }
            })
    break;

    case 2:
      tree = Object.entries(obj[packageId][label]).filter(function(entry) { // Remove summary entries
              return entry[0] !== "$";
            }).map(function(entry) {
              return {
                label: entry[0],
                packageId: packageId,
                level: 2,
                name: packageId + "-" + label + entry[0] + ": " + entry[1].name,
                Completeness: Number(entry[1].count),
              }
            });
    break;
  }

  tree.sort(
    function(a, b){
      return b.Completeness - a.Completeness
      });
  completeness.data.datasets[0].data = tree;
  completeness.update();
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
  tooltip: {
    position: {
      type: 'node',
    },
    range: 'nearest',
  },
};

agCharts.AgChart.create(options);

