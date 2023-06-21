const ctx = document.getElementById('issuesGraph');

const obj = JSON.parse("{$fields|escape:javascript}");

new Chart(ctx, {
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
      scales: {
        y: {
          beginAtZero: true
        }
      },
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
        tree: [
          {foreach from=$packages item=package}
            {if !isset($package->iscoretag) || $package->iscoretag}
              {
                label: '{$package->label|escape:javascript}',
                packageId: '{$package->packageid|escape:javascript}',
                level: 0,
                Completeness: {$package->count|escape:javascript},
              },
            {/if}
          {/foreach}
        ],
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
  const packageId = array[0].element.$context.raw._data.packageId;
  const label = array[0].element.$context.raw._data.label;

  if (level < 2 && level >= 0) {
    updateCompletenessContent(level + 1, packageId, label);
  }
}

function onCompletenessBack(event, array) {
  const level = completeness.data.datasets[0].tree[0].level
  const packageId = completeness.data.datasets[0].tree[0].packageId

  if (level <= 2 && level > 0) {
    updateCompletenessContent(level - 1, packageId, "");
  }
}

function updateCompletenessContent(level, packageId, label) {

  var tree = null;

  switch(level) {
    case 0:
      tree = Object.entries(obj).map(function(entry) {
              return {
                label: entry[0],
                packageId: packageId,
                level: 1,
                Completeness: Object.entries(entry[1]).reduce(function(total, subentry) {
                  return total + Number(Object.entries(subentry[1]).reduce(function(subtotal, subsubentry) {
                    return subtotal + Number(subsubentry[1].count)
                  }, 0))
                }, 0),
              }
            });

    case 1:
      tree = Object.entries(obj[packageId]).map(function(entry) {
              return {
                label: entry[0],
                packageId: packageId,
                level: 1,
                Completeness: Object.entries(entry[1]).reduce(function(total, subentry) {
                  return total + Number(subentry[1].count)
                }, 0),
              }
            });
    break;

    case 2:
      tree = Object.entries(obj[packageId][label]).map(function(entry) {
              return {
                label: entry[0],
                packageId: packageId,
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