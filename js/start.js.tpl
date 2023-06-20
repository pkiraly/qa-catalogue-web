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
    onClick: whatNow,
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

function whatNow(event, array) {
  const id = array[0].element.$context.raw._data.packageId;
  const level = array[0].element.$context.raw._data.level;
  const label = array[0].element.$context.raw._data.label;

  if (level < 2 && level >= 0) {
    const n = level === 0 ?
    Object.entries(obj[id]).map(function(entry) {
      return {
        label: entry[0],
        packageId: id,
        level: 1,
        Completeness: Object.entries(entry[1]).reduce(function(total, subentry) {
          return total + Number(subentry[1].count)
        }, 0),
      }
    }) :
    Object.entries(obj[id][label]).map(function(entry) {
      return {
        label: entry[0],
        packageId: id,
        level: 2,
        Completeness: Number(entry[1].count),
      }
    });

  completeness.data.datasets[0].tree = n;
  completeness.update();
  }
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