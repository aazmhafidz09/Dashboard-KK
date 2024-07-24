<script type="text/javascript">
    let CHART_STATISTIK_HAKI_FILTER = {
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
    };

    const dataHaki = {
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
        let targetElement = document.getElementById("chartHakiDosen") 
        updateChartStatistik(targetElement, kodeDosen)
    }

    function makeChartHaki() {
        const {kk, tahun} = CHART_STATISTIK_HAKI_FILTER;
        document.getElementById("chartStatistikHaki_KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartStatistikHaki_tahun").innerHTML = tahun;
        const targetElement = document.getElementById("chartStatistikHaki");
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
                        Object.entries(dataHaki[dosen])
                            .map((val, idx) => {
                                const [tahunHaki, nHaki] = val;
                                if(tahun == "Semua" || tahunHaki == tahun) {
                                    return nHaki
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
                    labels: { show: false, formatter: val => val + " Haki" }
                },
            }
        ).render();
    }
    function getChartColorsArray(chartId) {
        if (document.getElementById(chartId) !== null) {
            var colors = document.getElementById(chartId).getAttribute("data-colors");
            if (colors) {
                colors = JSON.parse(colors);
                return colors.map(function(value) {
                    var newValue = value.replace(" ", "");
                    if (newValue.indexOf(",") === -1) {
                        var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                        if (color) return color;
                        else return newValue;;
                    } else {
                        var val = value.split(',');
                        if (val.length == 2) {
                            var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                            rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                            return rgbaColor;
                        } else {
                            return newValue;
                        }
                    }
                });
            }
        }
    }
    // column chart with datalabels
    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, },
            },
            plotOptions: {
                bar: { dataLabels: { position: 'top', }, }
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: val => val + "",
                offsetY: -20,
                style: { fontSize: '12px', colors: ["#304758"] }
            },
            series: [{
                name: 'publikasi',
                data: [ <?php foreach ($order_by_tahun_Asc as $obt) {
                            echo '"' . $obt['jumlah_haki'] . '",';
                        } ?> ]
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
                labels: {
                    show: false,
                    formatter: val => val + " Haki"
                }
            },
        }

        new ApexCharts( document.querySelector("#column_chart_datalabel"), options).render();
    }


    // pie chart
    var PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        var options = {
            chart: { height: 320, type: 'pie', },
            series: [
                <?php echo $Haki_Cipta ?>, <?php echo $Haki_Paten ?>, 
                <?php echo $Haki_Merek ?>, <?php echo $Haki_Buku ?>
            ],
            labels: ["Hak Cipta", "Paten", "Merek", "Buku"],
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
                bar: { dataLabels: { position: 'top', }, }
            },
            dataLabels: {
                enabled: true,
                position: 'top', // top, center, bottom,
                formatter: val => val + "",
                offsetY: -20,
                style: { fontSize: '12px', colors: ["#304758"] }
            },
            series: [{
                name: 'Hak Cipta',
                data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                            echo '' . $cpub['Hak_Cipta'] . ',';
                        } ?>]
            }, {
                name: 'Paten',
                data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                            echo '' . $cpub['Paten'] . ',';
                        } ?>]
            }, {
                name: 'Merek',
                data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                            echo '' . $cpub['Merek'] . ',';
                        } ?>]
            }, {
                name: 'Buku',
                data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                            echo '' . $cpub['Buku'] . ',';
                        } ?>]
            }, ],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                                echo '' . $cpub['tahun'] . ',';
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
                labels: {
                    show: false,
                    formatter: val => val + " Haki"
                }
            },
        }

        new ApexCharts( document.querySelector("#column_chart"), options).render();
    }

    // column chart with datalabels
    let targetID = "chartStatistikHaki"
    var BarchartColumnChartColors = getChartColorsArray(targetID);
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, },
            },
            plotOptions: {
                bar: { dataLabels: { position: 'top', }, }
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
                data: dosenByKK[Object.keys(dosenByKK)[0]]
                    .map(dosen => (
                        Object
                            .values(dataHaki[dosen])
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
                    formatter: val => val + " Haki"
                }
            },
        }
        new ApexCharts(document.getElementById(targetID), options).render();
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
                data: [<?php foreach ($count_haki_all as $cpub) {
                            echo '' . $cpub['jumlah_haki'] . ',';
                        } ?>]
            }],
            colors: BarchartBarColors,
            grid: { borderColor: '#f1f1f1', },
            xaxis: { categories: ['Hak Cipta', 'Paten', 'Merek'], }
        }

        new ApexCharts( document.querySelector("#bar_chart"), options).render();
    }
</script>