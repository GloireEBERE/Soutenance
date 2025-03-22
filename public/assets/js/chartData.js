document.addEventListener("DOMContentLoaded", () => {
    if (chartData.length === 0) {
        document.getElementById("noDataMessage").style.display = "block";
        return;
    }

    let categories = chartData.map(item => `${item.year}-${('0' + item.month).slice(-2)}`);
    let seriesData = chartData.map(item => item.count);

    new ApexCharts(document.querySelector("#reportsChart"), {
        series: [{
            name: 'Stagiaires acceptés',
            data: seriesData
        }],
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
                show: false
            }
        },
        xaxis: {
            categories: categories,
            type: 'category',
        },
        markers: {
            size: 4
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        colors: ['#2eca6a'],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.4,
                stops: [0, 90, 100]
            }
        },
        tooltip: {
            x: {
                format: 'MM/yyyy'
            }
        }
    }).render();
});
