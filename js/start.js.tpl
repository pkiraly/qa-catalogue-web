const obj = JSON.parse("{$fields|escape:javascript}");

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
  type: 'treemap',
  data: {
    datasets: [
      {
        label: '# of records',
        key: 'Completeness',
        borderColor: 'green',
        borderWidth: 1,
        spacing: 0,
        backgroundColor: (ctx) => colorFromRaw(ctx),
      }
    ],
  },
  options: {
    plugins: {
      legend: {
        display: false
      }
    },
    onClick: onCompletenessClicked,
    responsive: true,
    aspectRatio: 1
  }
});

updateCompletenessContent(0, "", "");

document.getElementById("completenessBack").addEventListener('click', onCompletenessBack);

const totalCompletensGraphContext = document.getElementById('totalCompletenessGraph');

var totalCompleteness = new Chart(totalCompletensGraphContext, {
  type: 'doughnut',
  data: {
      labels: ['Without issues', 'With undefined fields', 'With issues'],
      datasets: [{
          label: '# of Records',
          data: [
            1,2,3
          ],
          backgroundColor: ["#37ba00", "#FFFF00", "#FF4136"],
          borderWidth: 1
      }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    },
    responsive: true
  }
});

function onCompletenessClicked(event, array) {
  const level = array[0].element.$context.raw._data.level;
  const packageName = array[0].element.$context.raw._data.packageName;
  const label = array[0].element.$context.raw._data.label;

  if (level < 2 && level >= 0) {
    updateCompletenessContent(level + 1, packageName, label);
  }
}

function onCompletenessBack() {
  const level = completeness.data.datasets[0].tree[0].level
  const packageName = completeness.data.datasets[0].tree[0].packageName

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
                Completeness: entry[1][""][""].count
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
                Completeness: entry[1][""].count
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

  completeness.data.datasets[0].tree = tree;
  completeness.update();
}

function colorFromRaw(ctx) {
  if (ctx.type !== 'data') {
    return 'transparent';
  }
  const value = ctx.raw.v;
  let alpha = (1 + Math.log(value)) / 5;
  const color = '#37ba00';
  return Chart.helpers.color(color)
    .alpha(alpha)
    .rgbString();
}