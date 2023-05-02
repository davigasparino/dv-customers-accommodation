
const doughnutData = {
    labels: [
        'Like',
        'Deslikes',
        'Nada'
    ],
    datasets: [{
        label: 'My First Dataset',
        data: [300, 50, 100],
        backgroundColor: [
            'rgb(38,142,212)',
            'rgb(243,66,124)',
            'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
    }]
};

new Chart("doughnutChart", {
    type: "doughnut",
    data: doughnutData
});

const dataRadar = {
    labels: [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho'
    ],
    datasets: [{
        label: 'My First Dataset',
        data: [65, 59, 90, 81, 56, 55, 40],
        fill: true,
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgb(255, 99, 132)',
        pointBackgroundColor: 'rgb(255, 99, 132)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(255, 99, 132)'
    }, {
        label: 'My Second Dataset',
        data: [28, 48, 40, 19, 96, 27, 100],
        fill: true,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgb(54, 162, 235)',
        pointBackgroundColor: 'rgb(54, 162, 235)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(54, 162, 235)'
    }]
};

new Chart("radarChart", {
    type: "radar",
    data: dataRadar,
    options: {
        elements: {
            line: {
                borderWidth: 3
            }
        }
    },
});

const dataBar = {
    labels: [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
    ],
    datasets: [{
        label: 'Janeiro',
        data: [65, 59, 80, 81, 56, 55, 40],
        backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 205, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(64,133,51, 07)',
        ],
        borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(63,157,100)',
        ],
        borderWidth: 1
    }]
};

new Chart("barChart", {
    type: 'bar',
    data: dataBar,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
});

const data = {
    labels: [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
    ],
    datasets: [{
        label: 'My First Dataset',
        data: [65, 59, 80, 81, 56, 55, 40],
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }]
};

new Chart("lineChart", {
    type: 'line',
    data: data,
});
