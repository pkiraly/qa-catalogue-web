const ctx = document.getElementById('issuesGraph');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Without issues', 'With undefined fields', 'With issues'],
        datasets: [{
            label: '# of Records',
            data: ['{$issueStats->good|escape:javascript}', '{$issueStats->unclear|escape:javascript}', '{$issueStats->bad|escape:javascript}'],
            backgroundColor: ["#2ECC40", "#FFFF00", "#FF4136"],
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