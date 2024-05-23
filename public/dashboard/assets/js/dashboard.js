(function ($) {
    "use strict";
    const currentURL = window.location.href;
    const parts = currentURL.split("/");
    const kelasId = parts[parts.indexOf("home") + 1];

    let datas;
    $.ajax({
        url: `/api/chart/${kelasId}`,
        type: "GET",
        success: function (response) {
            console.log(response);
            $(function () {
                Chart.defaults.global.legend.labels.usePointStyle = true;
                if ($("#visit-sale-chart").length) {
                    Chart.defaults.global.legend.labels.usePointStyle = true;
                    var ctx = document
                        .getElementById("visit-sale-chart")
                        .getContext("2d");
                    var gradientStrokePurple = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        181
                    );
                    gradientStrokePurple.addColorStop(
                        0,
                        "rgba(128, 0, 128, 1)"
                    ); // Ungu cerah
                    gradientStrokePurple.addColorStop(
                        1,
                        "rgba(255, 0, 255, 1)"
                    ); // Ungu lebih terang
                    var gradientLegendPurple =
                        "linear-gradient(to right, rgba(128, 0, 128, 1), rgba(255, 0, 255, 1))";

                    var gradientStrokeBlue = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        360
                    );
                    gradientStrokeBlue.addColorStop(0, "rgba(54, 215, 232, 1)");
                    gradientStrokeBlue.addColorStop(
                        1,
                        "rgba(177, 148, 250, 1)"
                    );
                    var gradientLegendBlue =
                        "linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))";

                    var gradientStrokePurple = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        300
                    );
                    gradientStrokePurple.addColorStop(
                        0,
                        "rgba(128, 0, 128, 1)"
                    );
                    gradientStrokePurple.addColorStop(
                        1,
                        "rgba(255, 0, 255, 1)"
                    );
                    var gradientLegendPurple =
                        "linear-gradient(to right, rgba(128, 0, 128, 1), rgba(255, 0, 255, 1))";

                    var myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: [
                                "JAN",
                                "FEB",
                                "MAR",
                                "APR",
                                "MAY",
                                "JUN",
                                "JUL",
                                "AUG",
                                "SEP",
                                "OCT",
                                "NOV",
                                "DEC",
                            ],
                            datasets: [
                                {
                                    label: "Pemasukan",
                                    borderColor: gradientStrokeBlue,
                                    backgroundColor: gradientStrokeBlue,
                                    hoverBackgroundColor: gradientStrokeBlue,
                                    legendColor: gradientLegendBlue,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: "origin",
                                    data: response.totalPemasukanPerBulan,
                                },
                                {
                                    label: "Pengeluaran",
                                    borderColor: gradientStrokePurple,
                                    backgroundColor: gradientStrokePurple,
                                    hoverBackgroundColor: gradientStrokePurple,
                                    legendColor: gradientLegendPurple,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: "origin",
                                    data: response.totalPengeluaranPerBulan,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            legend: false,
                            legendCallback: function (chart) {
                                var text = [];
                                text.push("<ul>");
                                for (
                                    var i = 0;
                                    i < chart.data.datasets.length;
                                    i++
                                ) {
                                    text.push(
                                        '<li><span class="legend-dots" style="background:' +
                                            chart.data.datasets[i].legendColor +
                                            '"></span>'
                                    );
                                    if (chart.data.datasets[i].label) {
                                        text.push(chart.data.datasets[i].label);
                                    }
                                    text.push("</li>");
                                }
                                text.push("</ul>");
                                return text.join("");
                            },
                            scales: {
                                // yAxes: [
                                //     {
                                //         ticks: {
                                //             display: false,
                                //             min: 0,
                                //             stepSize: 1000,
                                //             max: 1000000,
                                //         },
                                //         gridLines: {
                                //             drawBorder: false,
                                //             color: "rgba(235,237,242,1)",
                                //             zeroLineColor: "rgba(235,237,242,1)",
                                //         },
                                //     },
                                // ],
                                yAxes: [
                                    {
                                        ticks: {
                                            callback: function (
                                                value,
                                                index,
                                                values
                                            ) {
                                                return value.toLocaleString(
                                                    "id-ID",
                                                    {
                                                        style: "currency",
                                                        currency: "IDR",
                                                    }
                                                );
                                            },
                                        },
                                    },
                                ],
                                xAxes: [
                                    {
                                        gridLines: {
                                            display: true,
                                            drawBorder: false,
                                            color: "rgba(0,0,0,1)",
                                            zeroLineColor:
                                                "rgba(235,237,242,1)",
                                        },
                                        ticks: {
                                            padding: 20,
                                            fontColor: "#9c9fa6",
                                            autoSkip: true,
                                        },
                                        categoryPercentage: 0.5,
                                        barPercentage: 0.5,
                                    },
                                ],
                            },
                        },
                        elements: {
                            point: {
                                radius: 0,
                            },
                        },
                    });
                    $("#visit-sale-chart-legend").html(
                        myChart.generateLegend()
                    );
                }
                if ($("#payout-chart").length) {
                    Chart.defaults.global.legend.labels.usePointStyle = true;
                    var ctx = document
                        .getElementById("payout-chart")
                        .getContext("2d");

                    var gradientStrokeViolet = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        181
                    );
                    gradientStrokeViolet.addColorStop(
                        0,
                        "rgba(218, 140, 255, 1)"
                    );
                    gradientStrokeViolet.addColorStop(
                        1,
                        "rgba(154, 85, 255, 1)"
                    );
                    var gradientLegendViolet =
                        "linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))";

                    var gradientStrokeBlue = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        360
                    );
                    gradientStrokeBlue.addColorStop(0, "rgba(54, 215, 232, 1)");
                    gradientStrokeBlue.addColorStop(
                        1,
                        "rgba(177, 148, 250, 1)"
                    );
                    var gradientLegendBlue =
                        "linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))";

                    var gradientStrokeRed = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        300
                    );
                    gradientStrokeRed.addColorStop(0, "rgba(255, 191, 150, 1)");
                    gradientStrokeRed.addColorStop(1, "rgba(254, 112, 150, 1)");
                    var gradientLegendRed =
                        "linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))";

                    var myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: [
                                "JAN",
                                "FEB",
                                "MAR",
                                "APR",
                                "MAY",
                                "JUN",
                                "JUL",
                                "AUG",
                            ],
                            datasets: [
                                {
                                    label: "BALANCE",
                                    borderColor: gradientStrokeViolet,
                                    backgroundColor: gradientStrokeViolet,
                                    hoverBackgroundColor: gradientStrokeViolet,
                                    legendColor: gradientLegendViolet,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: "origin",
                                    data: [
                                        100000, 400000, 150000, 350000, 250000,
                                        500000, 300000, 200000,
                                    ],
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            legend: false,
                            legendCallback: function (chart) {
                                var text = [];
                                text.push("<ul>");
                                for (
                                    var i = 0;
                                    i < chart.data.datasets.length;
                                    i++
                                ) {
                                    text.push(
                                        '<li><span class="legend-dots" style="background:' +
                                            chart.data.datasets[i].legendColor +
                                            '"></span>'
                                    );
                                    if (chart.data.datasets[i].label) {
                                        text.push(chart.data.datasets[i].label);
                                    }
                                    text.push("</li>");
                                }
                                text.push("</ul>");
                                return text.join("");
                            },
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                            display: false,
                                            min: 0,
                                            stepSize: 1000,
                                            max: 1000000,
                                        },
                                        gridLines: {
                                            drawBorder: false,
                                            color: "rgba(235,237,242,1)",
                                            zeroLineColor:
                                                "rgba(235,237,242,1)",
                                        },
                                    },
                                ],
                                xAxes: [
                                    {
                                        gridLines: {
                                            display: true,
                                            drawBorder: false,
                                            color: "rgba(0,0,0,1)",
                                            zeroLineColor:
                                                "rgba(235,237,242,1)",
                                        },
                                        ticks: {
                                            padding: 20,
                                            fontColor: "#9c9fa6",
                                            autoSkip: true,
                                        },
                                        categoryPercentage: 0.5,
                                        barPercentage: 0.5,
                                    },
                                ],
                            },
                        },
                        elements: {
                            point: {
                                radius: 0,
                            },
                        },
                    });
                    $("#payout-chart-legend").html(myChart.generateLegend());
                }
                if ($("#visit-sale-chart-dark").length) {
                    Chart.defaults.global.legend.labels.usePointStyle = true;
                    var ctx = document
                        .getElementById("visit-sale-chart-dark")
                        .getContext("2d");

                    var gradientStrokeViolet = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        181
                    );
                    gradientStrokeViolet.addColorStop(
                        0,
                        "rgba(218, 140, 255, 1)"
                    );
                    gradientStrokeViolet.addColorStop(
                        1,
                        "rgba(154, 85, 255, 1)"
                    );
                    var gradientLegendViolet =
                        "linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))";

                    var gradientStrokeBlue = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        360
                    );
                    gradientStrokeBlue.addColorStop(0, "rgba(54, 215, 232, 1)");
                    gradientStrokeBlue.addColorStop(
                        1,
                        "rgba(177, 148, 250, 1)"
                    );
                    var gradientLegendBlue =
                        "linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))";

                    var gradientStrokeRed = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        300
                    );
                    gradientStrokeRed.addColorStop(0, "rgba(255, 191, 150, 1)");
                    gradientStrokeRed.addColorStop(1, "rgba(254, 112, 150, 1)");
                    var gradientLegendRed =
                        "linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))";

                    var myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: [
                                "JAN",
                                "FEB",
                                "MAR",
                                "APR",
                                "MAY",
                                "JUN",
                                "JUL",
                                "AUG",
                            ],
                            datasets: [
                                {
                                    label: "CHN",
                                    borderColor: gradientStrokeViolet,
                                    backgroundColor: gradientStrokeViolet,
                                    hoverBackgroundColor: gradientStrokeViolet,
                                    legendColor: gradientLegendViolet,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: "origin",
                                    data: [20, 40, 15, 35, 25, 50, 30, 20],
                                },
                                {
                                    label: "USA",
                                    borderColor: gradientStrokeRed,
                                    backgroundColor: gradientStrokeRed,
                                    hoverBackgroundColor: gradientStrokeRed,
                                    legendColor: gradientLegendRed,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: "origin",
                                    data: [40, 30, 20, 10, 50, 15, 35, 40],
                                },
                                {
                                    label: "UK",
                                    borderColor: gradientStrokeBlue,
                                    backgroundColor: gradientStrokeBlue,
                                    hoverBackgroundColor: gradientStrokeBlue,
                                    legendColor: gradientLegendBlue,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: "origin",
                                    data: [70, 10, 30, 40, 25, 50, 15, 30],
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            legend: false,
                            legendCallback: function (chart) {
                                var text = [];
                                text.push("<ul>");
                                for (
                                    var i = 0;
                                    i < chart.data.datasets.length;
                                    i++
                                ) {
                                    text.push(
                                        '<li><span class="legend-dots" style="background:' +
                                            chart.data.datasets[i].legendColor +
                                            '"></span>'
                                    );
                                    if (chart.data.datasets[i].label) {
                                        text.push(chart.data.datasets[i].label);
                                    }
                                    text.push("</li>");
                                }
                                text.push("</ul>");
                                return text.join("");
                            },
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                            display: false,
                                            min: 0,
                                            stepSize: 20,
                                            max: 80,
                                        },
                                        gridLines: {
                                            drawBorder: false,
                                            color: "#322f2f",
                                            zeroLineColor: "#322f2f",
                                        },
                                    },
                                ],
                                xAxes: [
                                    {
                                        gridLines: {
                                            display: false,
                                            drawBorder: false,
                                            color: "rgba(0,0,0,1)",
                                            zeroLineColor:
                                                "rgba(235,237,242,1)",
                                        },
                                        ticks: {
                                            padding: 20,
                                            fontColor: "#9c9fa6",
                                            autoSkip: true,
                                        },
                                        categoryPercentage: 0.5,
                                        barPercentage: 0.5,
                                    },
                                ],
                            },
                        },
                        elements: {
                            point: {
                                radius: 0,
                            },
                        },
                    });
                    $("#visit-sale-chart-legend-dark").html(
                        myChart.generateLegend()
                    );
                }
                if ($("#traffic-chart").length) {
                    var gradientStrokeGreen = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        181
                    );
                    gradientStrokeGreen.addColorStop(0, "rgba(0, 128, 0, 1)"); // Hijau cerah
                    gradientStrokeGreen.addColorStop(1, "rgba(0, 255, 0, 1)"); // Hijau lebih terang
                    var gradientLegendGreen =
                        "linear-gradient(to right, rgba(0, 128, 0, 1), rgba(0, 255, 0, 1))";

                    var gradientStrokeBlue = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        360
                    );
                    gradientStrokeBlue.addColorStop(0, "rgba(54, 215, 232, 1)");
                    gradientStrokeBlue.addColorStop(
                        1,
                        "rgba(177, 148, 250, 1)"
                    );
                    var gradientLegendPurple =
                        "linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))";

                    var gradientStrokePurple = ctx.createLinearGradient(
                        0,
                        0,
                        0,
                        300
                    );
                    gradientStrokePurple.addColorStop(
                        0,
                        "rgba(128, 0, 128, 1)"
                    );
                    gradientStrokePurple.addColorStop(
                        1,
                        "rgba(255, 0, 255, 1)"
                    );
                    var gradientLegendPurple =
                        "linear-gradient(to right, rgba(128, 0, 128, 1), rgba(255, 0, 255, 1))";

                    var trafficChartData = {
                        datasets: [
                            {
                                data: response.donut_data,
                                backgroundColor: [
                                    gradientStrokeBlue,
                                    gradientStrokePurple,
                                ],
                                hoverBackgroundColor: [
                                    gradientStrokeBlue,
                                    gradientStrokePurple,
                                ],
                                borderColor: [
                                    gradientStrokeBlue,
                                    gradientStrokePurple,
                                ],
                                legendColor: [
                                    gradientLegendBlue,
                                    gradientLegendPurple,
                                ],
                            },
                        ],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: ["Pemasukan", "Pengeluaran"],
                    };
                    var trafficChartOptions = {
                        responsive: true,
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                        },
                        legend: false,

                        legendCallback: function (chart) {
                            var text = [];
                            text.push("<ul>");
                            for (
                                var i = 0;
                                i < trafficChartData.datasets[0].data.length;
                                i++
                            ) {
                                text.push(
                                    '<li><span class="legend-dots" style="background:' +
                                        trafficChartData.datasets[0]
                                            .legendColor[i] +
                                        '"></span>'
                                );
                                if (trafficChartData.labels[i]) {
                                    text.push(trafficChartData.labels[i]);
                                }
                                text.push(
                                    '<span class="float-right">' +
                                        trafficChartData.datasets[0].data[i] +
                                        "%" +
                                        "</span>"
                                );
                                text.push("</li>");
                            }
                            text.push("</ul>");
                            return text.join("");
                        },
                    };
                    var trafficChartCanvas = $("#traffic-chart")
                        .get(0)
                        .getContext("2d");
                    var trafficChart = new Chart(trafficChartCanvas, {
                        type: "doughnut",
                        data: trafficChartData,
                        options: trafficChartOptions,
                    });
                    console.log(trafficChartData);
                    $("#traffic-chart-legend").html(
                        trafficChart.generateLegend()
                    );

                    $("#traffic-chart-legend").html(
                        trafficChart.generateLegend()
                    );
                }
                if ($("#inline-datepicker").length) {
                    $("#inline-datepicker").datepicker({
                        enableOnReadonly: true,
                        todayHighlight: true,
                    });
                }
            });
        },
    });
})(jQuery);
