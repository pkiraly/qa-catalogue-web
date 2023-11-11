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
            backgroundColor: ["#24A259", "#FFD166", "#EF476F"],
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
        labels: ['With authority name', 'Without authority name'],
        datasets: [{
            label: '# of Records',
            data: ['{$authorities->withClassification->count|escape:javascript}', '{$authorities->withoutClassification->count|escape:javascript}'],
            backgroundColor: ["#24A259", "#EF476F"],
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
        labels: ['With subjects', 'Without subjects'],
        datasets: [{
            label: '# of Records',
            data: ['{$classifications->withClassification->count|escape:javascript}', '{$classifications->withoutClassification->count|escape:javascript}'],
            backgroundColor: ["#24A259", "#EF476F"],
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
        backgroundColor: '#118AB2',
        hoverBackgroundColor: '#073B4C',
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
    parsing: {
      yAxisKey: 'label',
      xAxisKey: 'Completeness'
    },
    hover: {
      mode: 'index',
   }

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
  var location = "";

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
      location = "";
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
      console.debug(obj[packageId])
      location = obj[packageId][""][""].name;
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
            location = obj[packageId][label]["$"].name;
    break;
  }

  tree.sort(
    function(a, b){
      return b.Completeness - a.Completeness
      });
  completeness.data.datasets[0].data = tree;
  document.getElementById("location").innerHTML = location;
  completeness.update();
}

const boothShelfReadyContext = document.getElementById('boothShelfReady');
{literal}
const boothShelfReady = Object.keys(shelf_ready_data).map((i) => ({"Score": parseFloat(i), "Number of Records": parseInt(shelf_ready_data[i])}));
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
      fill: "#118AB2",
      stroke: "#073B4C",
      highlightStyle: {
        item: {
          fill: '#073B4C'
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
