<script type="text/javascript">
    // column chart with datalabels
    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel_count_per_tahun");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: function(val) {
                    return val + "";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'publikasi',
                data: [
                    <?php foreach ($order_by_tahun_Asc as $obt) {
                        echo '"' . $obt['jumlah_pen'] . '",';
                    }

                    ?>
                    // 8, 14, 15, 15, 17, 22, 38, 39, 56, 42
                ]
            }],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {

                categories: [<?php foreach ($order_by_tahun_Asc as $obt) {
                                    echo '"' . $obt['thn'] . '",';
                                }
                                ?> '2024'],
                position: 'down',
                labels: {
                    offsetY: 0,

                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: true
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 1,
                            opacityTo: 1,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
            },
            fill: {
                gradient: {
                    shade: 'light',
                    type: "horizontal",
                    shadeIntensity: 0.25,
                    gradientToColors: undefined,
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return val + " Penelitian";
                    }
                }

            },

        }

        var chart = new ApexCharts(
            document.querySelector("#column_chart_datalabel_count_per_tahun"),
            options
        );

        chart.render();

    }


    // pie chart
    var PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        var options = {
            chart: {
                height: 320,
                type: 'pie',
            },
            series: [<?php foreach ($count_publikasi_all as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>],
            labels: [<?php foreach ($count_publikasi_all as $cpub) {
                            echo '"' . $cpub['jenis_pen'] . '",';
                        }

                        ?>],

            colors: PiechartPieColors,
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '14px',
                offsetX: 0
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]

        }

        var chart = new ApexCharts(
            document.querySelector("#pie_chart"),
            options
        );

        chart.render();

    }


    // column chart
    var BarchartColumnColors = getChartColorsArray("column_chart");
    if (BarchartColumnColors) {

        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: function(val) {
                    return val + "";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'Jurnal Internasional',
                data: [<?php foreach ($getOrderByTahunJurnalInternasional as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Jurnal Nasional',
                data: [<?php foreach ($getOrderByTahunJurnalNasional as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Konferensi Internasional',
                data: [<?php foreach ($getOrderByTahunKonferensiInternasional as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Konferensi Nasional',
                data: [<?php foreach ($getOrderByTahunKonferensiNasional as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, ],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {

                categories: [<?php foreach ($getOrderByTahunJurnalInternasional as $cpub) {
                                    echo '' . $cpub['thn'] . ',';
                                }

                                ?> 2024],
                position: 'down',
                labels: {
                    offsetY: 0,

                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: true
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 1,
                            opacityTo: 1,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
            },
            fill: {
                gradient: {
                    shade: 'light',
                    type: "horizontal",
                    shadeIntensity: 0.25,
                    gradientToColors: undefined,
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return val + " Penelitian";
                    }
                }

            },

        }
        var chart = new ApexCharts(
            document.querySelector("#column_chart"),
            options
        );

        chart.render();

    }

    // Bar chart
    var BarchartBarColors = getChartColorsArray("bar_chart");
    if (BarchartBarColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                data: [<?php foreach ($count_publikasi_all as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }],
            colors: BarchartBarColors,
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {
                categories: ['Jurnal Internasional', 'Jurnal Nasional', 'Prosiding Internasional', 'Prosiding Nasional'],
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#bar_chart"),
            options
        );

        chart.render();

    }

    // column chart with datalabels
    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel_1");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: function(val) {
                    return val + "";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'Publikasi',
                data: [<?php foreach ($top_publikasi_all as $cpub) {
                            echo '"' . $cpub['jumlah_publikasi'] . '",';
                        }

                        ?>]
            }],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {

                categories: [<?php foreach ($top_publikasi_all as $cpub) {
                                    echo '"' . $cpub['kode_dosen'] . '",';
                                }

                                ?>],
                position: 'down',
                labels: {
                    offsetY: 0,

                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: true
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 1,
                            opacityTo: 1,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
            },
            fill: {
                gradient: {
                    shade: 'light',
                    type: "horizontal",
                    shadeIntensity: 0.25,
                    gradientToColors: undefined,
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return val + " Penelitian";
                    }
                }

            },

        }

        var chart = new ApexCharts(
            document.querySelector("#column_chart_datalabel_1"),
            options
        );

        chart.render();

    }
</script>