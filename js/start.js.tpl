const ctx = document.getElementById('issuesGraph');

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
  }
});

function whatNow(event, array) {
  console.info("It works!!!");
  console.info(array);
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