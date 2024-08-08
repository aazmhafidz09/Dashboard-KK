<script type="text/javascript">
    let FILTER_HAKI_PER_TAHUN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_HAKI_PER_JENIS_TAHUNAN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_HAKI_PER_DOSEN = {
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
    };
    let FILTER_HAKI_DOSEN = {
        kodeDosen: ""
    }

    const displayedHakiTypes = ["HAK CIPTA", "PATEN", "MEREK", "DESAIN INDUSTRI"];
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

    const dataHakiAnyKKTahunan = [
        {
            name: 'Hak Cipta',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['Hak_Cipta'] . ',';
                    } ?>]
        }, 
        {
            name: 'Paten',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['Paten'] . ',';
                    } ?>]
        }, 
        {
            name: 'Merek',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['Merek'] . ',';
                    } ?>]
        }, 
        {
            name: 'Desain Industri',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['Desain_Industri'] . ',';
                    } ?>]
        }
    ]

    const dataHakiAnyKind = {
        <?php foreach ($order_by_tahun_Asc as $obt) {
            echo '"' . $obt['thn'] . '": '. $obt['jumlah_haki'] . ',';
        } ?>
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

    const dataHakiPerKKTahunan = { "CITI": {}, "SEAL": {}, "DSIS": {} };
    <?php foreach($annualHakiByTypeAndKK as $row): ?>
        if(!dataHakiPerKKTahunan['<?= $row["kk"] ?>'].hasOwnProperty('<?= $row["tahun"] ?>')) {
            dataHakiPerKKTahunan['<?= $row["kk"] ?>'][<?= $row["tahun"] ?>] = {};
        }

        dataHakiPerKKTahunan['<?= $row["kk"] ?>'][<?= $row["tahun"] ?>]['<?= $row["jenis"] ?>'] = <?= $row["nHaki"] ?>;
    <?php endforeach ?>

    const onDataPointSelection = function(e, context, opts) {
        const kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex];
        if(kodeDosen != FILTER_HAKI_DOSEN.kodeDosen) {
            FILTER_HAKI_DOSEN.kodeDosen = kodeDosen;
            document.getElementById("chartHaki__desc").innerHTML = ""
            document.getElementById("chartHaki__title").innerHTML = `Statistik Haki ${kodeDosen}`

            const targetElement = document.getElementById("chartHakiDosen");
            const dataHakiDosen = dataHaki[kodeDosen];
            targetElement.innerHTML = "";
            makeChartHakiDosen(
                targetElement, 
                Object.keys(dataHakiDosen), 
                Object.values(dataHakiDosen))
        }
    }

    function makeChartHakiPerTahun(targetElement, labels, values) {
        new ApexCharts( 
            targetElement,
            {
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
                series: [{ name: 'Haki', data: values }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: labels,
                    position: 'down',
                    labels: { offsetY: 0, rotate: 270},
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
                        formatter: val => val + ""
                    }
                },
        }).render();
    }

    function makeChartHakiPerJenisTahunan(targetElement, labels, values) {
        new ApexCharts( 
            targetElement,
            {
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
                series: values,
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: labels,
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
                        formatter: val => val + ""
                    }
                },
            }
        ).render();
    }

    function makeChartHakiDosen(targetElement, labels, values) {
        new ApexCharts( 
            targetElement,
            {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false, },
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
                series: [{ name: 'Haki', data:  values }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: labels,
                    position: 'down',
                    labels: { offsetY: 0, rotate: 270},
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
                    labels: { show: false, formatter: val => val + "" }
                },
            }
        ).render();
    }

    function makeChartHakiPerDosen(targetElement, labels, values) {
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
                series: [{ name: 'Haki', data:  values }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: labels,
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
                    labels: { show: false, formatter: val => val + "" }
                },
            }
        ).render();
    }

    function onHakiPerDosenFilterUpdate() {
        const {kk, tahun} = FILTER_HAKI_PER_DOSEN;
        document.getElementById("chartHakiPerDosen__KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartHakiPerDosen__tahun").innerHTML = tahun;
        const chartLabels = dosenByKK[kk]
        const chartValues = dosenByKK[kk].map(dosen => (
            Object.entries(dataHaki[dosen])
                .map((val, idx) => {
                    const [tahunHaki, nHaki] = val;
                    return tahun == "Semua" || tahunHaki == tahun? nHaki: 0;
                })
                .reduce((acc, val) => acc + val, 0)
            )
        )

        const targetElement = document.getElementById("chartHakiPerDosen");
        targetElement.innerHTML = "";
        makeChartHakiPerDosen(targetElement, chartLabels, chartValues);
    }

    function onHakiPerJenisTahunanFilterUpdate() {
        const {kk} = FILTER_HAKI_PER_JENIS_TAHUNAN;
        const chartLabels = [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                                echo '' . $cpub['tahun'] . ',';
                            } ?>]   

        let chartValues = dataHakiAnyKKTahunan;
        document.getElementById("chartHakiPerJenisTahunan__KK").innerHTML = 'Semua';
        if(kk != "") {
            document.getElementById("chartHakiPerJenisTahunan__KK").innerHTML = `KK ${kk}`;
            chartValues = (
                displayedHakiTypes
                    .map(hakiType => ({
                        name: hakiType,
                        data: chartLabels
                                .map(hakiYear => {
                                    hakiPerYear = dataHakiPerKKTahunan[kk][hakiYear]
                                    return (
                                        (
                                            hakiPerYear == undefined ||
                                            hakiPerYear[hakiType] == undefined
                                        )
                                        ? 0: hakiPerYear[hakiType]
                                    )
                                })
                    }))
            )
        }

        const targetElement = document.getElementById("chartHakiPerJenisTahunan");
        targetElement.innerHTML = "";
        makeChartHakiPerJenisTahunan(targetElement, chartLabels, chartValues);
    }

    function onHakiPerTahunFilterUpdate() {
        const {kk} = FILTER_HAKI_PER_TAHUN;
        document.getElementById("chartHakiPerTahun__KK").innerHTML = `Semua`;
        let chartLabels = Object.keys(dataHakiAnyKind)
        let chartValues = Object.values(dataHakiAnyKind)

        if(kk != "") {
            document.getElementById("chartHakiPerTahun__KK").innerHTML = `KK ${kk}`;
            chartLabels = Object.keys(dataHakiPerKKTahunan[kk])
            chartValues = Object.values(dataHakiPerKKTahunan[kk])
                                .map(HakiType => (
                                    Object.values(HakiType)
                                          .reduce((acc, val) => acc + val, 0)
                                ))
        }

        const targetElement = document.getElementById("chartHakiPerTahun");
        targetElement.innerHTML = "";
        makeChartHakiPerTahun(targetElement, chartLabels, chartValues);
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

    // Bar chart
    var BarchartBarColors = getChartColorsArray("bar_chart");
    if (BarchartBarColors) {
        new ApexCharts( 
            document.getElementById("bar_chart"), 
            {
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
                xaxis: { categories: displayedHakiTypes, }
            }
        ).render();

    }

    var PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        new ApexCharts( 
            document.getElementById("pie_chart"), 
        {
                chart: { height: 320, type: 'pie', },
                series: [
                    <?php echo $Haki_Cipta ?>, <?php echo $Haki_Paten ?>, 
                    <?php echo $Haki_Merek ?>, <?php echo $Haki_Desain_Industri ?>
                ],
                labels: displayedHakiTypes,
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
        ).render();
    }

    makeChartHakiPerTahun(
        document.getElementById("chartHakiPerTahun"),
        Object.keys(dataHakiAnyKind),
        Object.values(dataHakiAnyKind),
    )
    makeChartHakiPerJenisTahunan(
        document.getElementById("chartHakiPerJenisTahunan"),
        [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
            echo '' . $cpub['tahun'] . ',';
        } ?>],
        dataHakiAnyKKTahunan
    )
    makeChartHakiPerDosen(
        document.getElementById("chartHakiPerDosen"),
        dosenByKK[Object.keys(dosenByKK)[0]],
        dosenByKK[Object.keys(dosenByKK)[0]]
            .map(dosen => (
                Object
                    .values(dataHaki[dosen])
                    .reduce((acc, val) => acc + val, 0)
                )
        ),
    )

</script>