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
        }
    }
});

const completensGraphContext = document.getElementById('completenessGraph');

new Chart(completensGraphContext, {
    type: 'treemap',
    data: {
    datasets: [
      {
        label: 'Text in tooltip',
        labels: {
            display: true,
            formatter: (ctx) => 'Kmq ' + ctx.raw.v,
        },
        tree: [
            15,6,6,3
        ],
        borderColor: 'green',
        borderWidth: 1,
        spacing: 0,
        backgroundColor: (ctx) => colorFromRaw(ctx),
      }
    ],
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'My treemap chart'
      },
      legend: {
        display: false
      }
    }
  }
});

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