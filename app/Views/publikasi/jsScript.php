<script type="text/javascript">
    let FILTER_PUBLIKASI_PER_TAHUN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PUBLIKASI_PER_JENIS_TAHUNAN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PUBLIKASI_PER_DOSEN = {
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
    };

    const displayedPublikasiTypes = [
        "JURNAL INTERNASIONAL", "JURNAL NASIONAL",
        "PROSIDING INTERNASIONAL", "PROSIDING NASIONAL"
    ]

    const dataPublikasi = {
        <?php
            foreach($data_tahunan as $data) {
                echo "'" . $data["kode_dosen"] . "': {";
                foreach(array_keys($data) as $label) {
                    $pattern = "THN_";
                    $pos = strpos($label, $pattern);
                    if($pos !== false) {
                        $year = substr($label, $pos + strlen($pattern));
                        echo "'" . $year . "': " . $data[$pattern . $year] . ",";
                    }
                }
                echo "},";
            }
        ?>
    }

    const dataPublikasiPerKKTahunan = { "CITI": {}, "SEAL": {}, "DSIS": {} };
    <?php foreach($annualPublikasiByTypeAndKK as $row): ?>
        if(!dataPublikasiPerKKTahunan['<?= $row["kk"] ?>'].hasOwnProperty('<?= $row["tahun"] ?>')) {
            dataPublikasiPerKKTahunan['<?= $row["kk"] ?>'][<?= $row["tahun"] ?>] = {};
        }

        dataPublikasiPerKKTahunan['<?= $row["kk"] ?>'][<?= $row["tahun"] ?>]['<?= strtoupper($row["jenis"]) ?>'] = <?= $row["nPublikasi"] ?>;
    <?php endforeach ?>

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

    const dataPublikasiAnyKKTahunan = [{
            name: 'Jurnal Internasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_jurnal_internasional'] . ',';
                    } ?>]
        }, {
            name: 'Jurnal Nasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_jurnal_nasional'] . ',';
                    } ?>]
        }, {
            name: 'Konferensi Internasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_prosiding_internasional'] . ',';
                    } ?>]
        }, {
            name: 'Konferensi Nasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_prosiding_nasional'] . ',';
                    } ?>]
        }, 
    ] 

    const dataPublikasiAnyKind = {
        <?php foreach ($order_by_tahun_Asc as $obt) {
            echo '"' . $obt['thn']. '":' . $obt['jumlah_pen'] . ',';
        } ?>
    }

    const onDataPointSelection = function(e, context, opts) {
        let kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex]
        let targetElement = document.getElementById("chartPublikasiDosen") 
        updateChartStatistik(targetElement, kodeDosen)
    }

    function makeChartPublikasiPerTahun(targetElement, labels, values) {
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
                series: [{ name: 'publikasi', data: values }],
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
                    labels: {
                        show: false,
                        formatter: val => val + " Publikasi"
                    }
                },
            }
        ).render();
    }

    function makeChartPublikasiPerJenisTahunan(targetElement, labels, values) {
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
                        formatter: val => val + " Publikasi"
                    }
                },
            }
        ).render();
    }

    function makeChartPublikasiPerDosen(targetElement, labels, values) {
        new ApexCharts(
            targetElement,
            {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false, },
                    events: { dataPointSelection: onDataPointSelection }
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
                    formatter: val => val + "",
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#304758"] }
                },
                series: [{ name: 'Publikasi', data: values, }],
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
                    labels: {
                        show: false,
                        formatter: val => val + " Publikasi"
                    }
                },
            }
        ).render();
    }

    function onPublikasiPerTahunFilterUpdate() {
        const {kk} = FILTER_PUBLIKASI_PER_TAHUN;
        document.getElementById("chartPublikasiPerTahun__KK").innerHTML = `Semua`;
        let chartLabels = Object.keys(dataPublikasiAnyKind);
        let chartValues = Object.values(dataPublikasiAnyKind);

        if(kk != "") {
            document.getElementById("chartPublikasiPerTahun__KK").innerHTML = `KK ${kk}`;
            chartLabels = Object.keys(dataPublikasiPerKKTahunan[kk])
            chartValues = Object.values(dataPublikasiPerKKTahunan[kk])
                                .map(abdimasType => (
                                    Object.values(abdimasType)
                                          .reduce((acc, val) => acc + val, 0)
                                ))
        }

        const targetElement = document.getElementById("chartPublikasiPerTahun");
        targetElement.innerHTML = "";
        makeChartPublikasiPerTahun(targetElement, chartLabels, chartValues);


    }

    function onPublikasiPerJenisTahunanFilterUpdate() {
        const {kk} = FILTER_PUBLIKASI_PER_JENIS_TAHUNAN;
        const chartLabels = [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                                echo '' . $cpub['tahun'] . ',';
                            } ?>]   

        let chartValues = dataPublikasiAnyKKTahunan;
        document.getElementById("chartPublikasiPerJenisTahunan__KK").innerHTML = 'Semua';
        if(kk != "") {
            document.getElementById("chartPublikasiPerJenisTahunan__KK").innerHTML = `KK ${kk}`;
            chartValues = (
                displayedPublikasiTypes
                    .map(publikasiType => ({
                        name: publikasiType,
                        data: chartLabels
                                .map(publikasiYear => {
                                    publikasiPerYear = dataPublikasiPerKKTahunan[kk][publikasiYear]
                                    return (
                                        (
                                            publikasiPerYear == undefined ||
                                            publikasiPerYear[publikasiType] == undefined
                                        )
                                        ? 0: publikasiPerYear[publikasiType]
                                    )
                                })
                    }))
            )
        }

        const targetElement = document.getElementById("chartPublikasiPerJenisTahunan");
        targetElement.innerHTML = "";
        makeChartPublikasiPerJenisTahunan(targetElement, chartLabels, chartValues);

    }

    function onPublikasiPerDosenFilterUpdate() {
        const {kk, tahun} = FILTER_PUBLIKASI_PER_DOSEN;
        document.getElementById("chartPublikasiPerDosen__KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartPublikasiPerDosen__tahun").innerHTML = tahun;

        const chartLabels = dosenByKK[kk];
        const chartValues = dosenByKK[kk].map(dosen => (
                                Object.entries(dataPublikasi[dosen])
                                    .map((val, idx) => {
                                        const [tahunPublikasi, nPublikasi] = val;
                                        return (
                                            (tahun == "Semua" || tahunPublikasi == tahun)
                                            ? nPublikasi: 0
                                        )
                                    })
                                    .reduce((acc, val) => acc + val, 0)
                                )
                            )
        const targetElement = document.getElementById("chartPublikasiPerDosen");
        targetElement.innerHTML = "";
        makeChartPublikasiPerDosen( targetElement, chartLabels, chartValues)
    }

    const updateChartStatistik = function(target, newKodeDosen) {
        const dataPublikasiDosen = dataPublikasi[newKodeDosen];
        document.getElementById("chartPublikasi__desc").innerHTML = ""
        document.getElementById("chartPublikasi__title").innerHTML = `Statistik Publikasi ${newKodeDosen}`
        target.innerHTML = "";

        new ApexCharts(
            target,  
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
                series: [{
                    name: 'Publikasi',
                    data: Object.values(dataPublikasiDosen)
                }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: Object.keys(dataPublikasiDosen),
                    position: 'down',
                    labels: { offsetY: 0, rotate:270, rotateAlways: true},
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
                        formatter: val => val + " Publikasi"
                    }
                },
            }
        ) .render();
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

    // pie chart
    const PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        new ApexCharts( 
            document.getElementById("pie_chart"), 
            {
                chart: { height: 320, type: 'pie', },
                series: [<?php foreach ($count_publikasi_all as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        } ?>],
                labels: [<?php foreach ($count_publikasi_all as $cpub) {
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
        ).render();

    }

    // Bar chart
    const BarchartBarColors = getChartColorsArray("bar_chart");
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
                    data: [<?php foreach ($akreditasi_jurnal as $cpub) {
                                echo '' . $cpub['jumlah_akr'] . ',';
                            } ?>]
                }],
                colors: BarchartBarColors,
                grid: { borderColor: '#f1f1f1', },
                xaxis: { categories: ['Q1', 'Q2', 'Q3', 'Q4', 'S1', 'S2', 'S3', 'S4', 'S5'], }
            }
        ).render();
    }

    makeChartPublikasiPerTahun(
        document.getElementById("chartPublikasiPerTahun"),
        Object.keys(dataPublikasiAnyKind),
        Object.values(dataPublikasiAnyKind)
    )
    makeChartPublikasiPerJenisTahunan(
        document.getElementById("chartPublikasiPerJenisTahunan"),
        [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
            echo '' . $cpub['tahun'] . ',';
        } ?>],
        dataPublikasiAnyKKTahunan
    )
    makeChartPublikasiPerDosen(
        document.getElementById("chartPublikasiPerDosen"),
        dosenByKK[Object.keys(dosenByKK)[0]],
        dosenByKK[Object.keys(dosenByKK)[0]].map(dosen => (
                                Object.values(dataPublikasi[dosen])
                                    .reduce((acc, val) => acc + val, 0)
                                ))
    )
</script>