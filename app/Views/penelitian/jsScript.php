<script type="text/javascript">
    let CHART_STATISTIK_PENELITIAN_FILTER = {
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
    };

    const dataPenelitian = {
        <?php
            foreach($data_tahunan as $d) {
                echo "'" . $d["kode_dosen"] . "': {";
                foreach(array_keys($d) as $label) {
                    $pattern = "THN_";
                    $pos = strpos($label, $pattern);
                    if($pos !== false) {
                        $year = substr($label, $pos + strlen($pattern));
                        echo "'" . $year . "': " . $d[$pattern . $year] . ",";
                    }
                }
                echo "},";
            }
        ?>
    }

    const dosenByKK = { 
        <?php
            foreach($dosenByKK as $kkDosen => $dosenList) {
                echo "'" . $kkDosen . "'" . ": [";
                foreach($dosenList as $dosen) {
                    echo "'" . $dosen . "'" . ", ";
                }
                echo "],";
            }
        ?> 
    };

    const onDataPointSelection = function(e, context, opts) {
        let kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex]
        let targetElement = document.getElementById("chartPenelitianDosen") 
        updateChartStatistik(targetElement, kodeDosen)
    }

    function makeChartPenelitian() {
        const {kk, tahun} = CHART_STATISTIK_PENELITIAN_FILTER;
        document.getElementById("chartStatistikPenelitian_KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartStatistikPenelitian_tahun").innerHTML = tahun;
        const targetElement = document.getElementById("chartStatistikPenelitian");
        targetElement.innerHTML = "";
        new ApexCharts(
            targetElement,
            {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false, },
                    events: { dataPointSelection: onDataPointSelection}
                },
                plotOptions: {
                    bar: { dataLabels: { position: 'top'}, }
                },
                dataLabels: {
                    enabled: true,
                    position: 'top', // top, center, bottom,
                    formatter: val => val + "",
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#304758"] }
                },
                series: [{
                    name: 'abdimas',
                    data: dosenByKK[kk].map(dosen => (
                        Object.entries(dataPenelitian[dosen])
                            .map((val, idx) => {
                                const [tahunPenelitian, nPenelitian] = val;
                                if(tahun == "Semua" || tahunPenelitian == tahun) {
                                    return nPenelitian
                                }

                                return 0;
                            })
                            .reduce((acc, val) => acc + val, 0)
                        )
                    ),
                }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: dosenByKK[kk],
                    position: 'down',
                    labels: { offsetY: 0, rotate: 270, rotateAlways: true},
                    axisBorder: { show: false },
                    axisTicks: { show: true },
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
                    tooltip: { enabled: true, offsetY: -35, }
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
                    axisBorder: { show: false },
                    axisTicks: { show: false, },
                    labels: { show: false, formatter: val => val + " Penelitian" }
                },
            }
        ).render();
    }

    const updateChartStatistik = function(target, newKodeDosen) {
        const dataPublikasiDosen = dataPenelitian[newKodeDosen];
        document.getElementById("chartPenelitian__desc").innerHTML = ""
        document.getElementById("chartPenelitian__title").innerHTML = `Statistik Penelitian ${newKodeDosen}`
        const chart = new ApexCharts(
            target,  
            {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false, },
                    events: { dataPointSelection: onDataPointSelection}
                },
                plotOptions: {
                    bar: { dataLabels: { position: 'top',}, } // top, center, bottom
                },
                dataLabels: {
                    enabled: true,
                    position: 'top', // top, center, bottom,
                    formatter: val => val + "",
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#304758"] }
                },
                series: [{
                    name: 'Publikasi',
                    data: Object.values(dataPublikasiDosen)
                }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: Object.keys(dataPublikasiDosen),
                    position: 'down',
                    labels: { offsetY: 0, },
                    axisBorder: { show: false },
                    axisTicks: { show: true },
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
                    tooltip: { enabled: true, offsetY: -35, }
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
                    axisBorder: { show: false },
                    axisTicks: { show: false, },
                    labels: {
                        show: false,
                        formatter: val => val + " Penelitian"
                    }
                },
            }
        );

        target.innerHTML = "";
        chart.render();
    }

    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, }
            },
            plotOptions: {
                bar: { dataLabels: { position: 'top', }, } // top, center, bottom
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: val => val + "",
                offsetY: -20,
                style: { fontSize: '12px', colors: ["#304758"] }
            },
            series: [{
                name: 'penelitian',
                data: [ <?php foreach ($order_by_tahun_Asc as $obt) {
                            echo '"' . $obt['jumlah_pen'] . '",';
                        } ?> ] // 8, 14, 15, 15, 17, 22, 38, 39, 56, 42
            }],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [<?php foreach ($order_by_tahun_Asc as $obt) {
                                echo '"' . $obt['thn'] . '",';
                            } ?>],
                position: 'down',
                labels: { offsetY: 0, },
                axisBorder: { show: false },
                axisTicks: { show: true },
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
                tooltip: { enabled: true, offsetY: -35, }
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
                axisBorder: { show: false },
                axisTicks: { show: false, },
                labels: { show: false, formatter: val => val + " Penelitian" }
            },
        }
        new ApexCharts( document.querySelector("#column_chart_datalabel"), options).render();

    }

    // pie chart
    var PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        var options = {
            chart: { height: 320, type: 'pie', },
            series: [<?php foreach ($count_publikasi as $cpub) {
                        echo '' . $cpub['jumlah_pen'] . ',';
                    } ?>],
            labels: [<?php foreach ($count_publikasi as $cpub) {
                        echo '"' . $cpub['jenis_pen'] . '",';
                    } ?>],
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
                    chart: { height: 240 },
                    legend: { show: false },
                }
            }]

        }

        new ApexCharts( document.querySelector("#pie_chart"), options).render();
    }


    // column chart
    var BarchartColumnColors = getChartColorsArray("column_chart");
    if (BarchartColumnColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, }
            },
            plotOptions: {
                bar: { dataLabels: { position: 'top',}} // top, center, bottom
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: val => val + "",
                offsetY: -20,
                style: { fontSize: '12px', colors: ["#304758"] }
            },
            series: [{
                name: 'Eksternal',
                data: [<?php foreach ($getOrderByTahunEksternal as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>]
            }, {
                name: 'Internal',
                data: [<?php foreach ($getOrderByTahunInternal as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>]
            }, {
                name: 'Mandiri',
                data: [<?php foreach ($getOrderByTahunMandiri as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>]
            }, {
                name: 'Kerja Sama PT',
                data: [<?php foreach ($getOrderByTahunKerjasamaPT as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>]
            }, {
                name: 'Hilirisasi',
                data: [<?php foreach ($getOrderByTahunHilirisasi as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>]
            }, ],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [<?php foreach ($getOrderByTahunEksternal as $cpub) {
                                echo '' . $cpub['thn'] . ',';
                            } ?>],
                position: 'down',
                labels: { offsetY: 0, },
                axisBorder: { show: false },
                axisTicks: { show: true },
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
                tooltip: { enabled: true, offsetY: -35, }
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
                axisBorder: { show: false },
                axisTicks: { show: false, },
                labels: { show: false, formatter: val => val + " Penelitian"}
            },

        }
        new ApexCharts( document.querySelector("#column_chart"), options).render();
    }

    // Bar chart
    var BarchartBarColors = getChartColorsArray("bar_chart");
    if (BarchartBarColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, }
            },
            plotOptions: {
                bar: { horizontal: true, }
            },
            dataLabels: { enabled: false },
            series: [{
                data: [<?php foreach ($count_publikasi as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>]
            }],
            colors: BarchartBarColors,
            grid: { borderColor: '#f1f1f1', },
            xaxis: { categories: ['Eksternal', 'Hilirisasi', 'Internal', 'Kemitraan', 'Kerja Sama PT', 'Mandiri'], }
        }

        new ApexCharts( document.querySelector("#bar_chart"), options).render();
    }

    // column chart with datalabels
    let targetID = "chartStatistikPenelitian";
    var statistikPenelitian = getChartColorsArray(targetID);
    if (statistikPenelitian) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, },
                events: { dataPointSelection: onDataPointSelection }
            },
            plotOptions: {
                bar: {
                    dataLabels: { position: 'top',}, // top, center, bottom },
                }
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: val => val + "",
                offsetY: -20,
                style: { fontSize: '12px', colors: ["#304758"] }
            },
            series: [{
                name: 'Penelitian',
                data: dosenByKK[Object.keys(dosenByKK)[0]]
                    .map(dosen => (
                        Object
                            .values(dataPenelitian[dosen])
                            .reduce((acc, val) => acc + val, 0)
                        )
                ),

            }],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: dosenByKK[Object.keys(dosenByKK)[0]],
                position: 'down',
                labels: { offsetY: 0, rotate: 270, rotateAlways: true},
                axisBorder: { show: false },
                axisTicks: { show: true },
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
                tooltip: { enabled: true, offsetY: -35, }
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
                axisBorder: { show: false },
                axisTicks: { show: false, },
                labels: {
                    show: false,
                    formatter: val => val + " Penelitian"
                }
            },
        }

        new ApexCharts( document.getElementById(targetID), options).render();
    }
</script>