<script type="text/javascript">
    let FILTER_PENELITIAN_PER_TAHUN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PENELITIAN_PER_JENIS_TAHUNAN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PENELITIAN_PER_DOSEN = {
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
    };

    const displayedPenelitianTypes = [
        "INTERNAL", "EKSTERNAL", "MANDIRI", "KERJASAMA PERGURUAN TINGGI", "HILIRISASI",  //"MANDIRI"
    ];
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

    const dataPenelitianPerKKTahunan = { "CITI": {}, "SEAL": {}, "DSIS": {} };
    <?php foreach($annualPenelitianByTypeAndKK as $row): ?>
        if(!dataPenelitianPerKKTahunan['<?= $row["kk"] ?>'].hasOwnProperty('<?= $row["tahun"] ?>')) {
            dataPenelitianPerKKTahunan['<?= $row["kk"] ?>'][<?= $row["tahun"] ?>] = {};
        }

        dataPenelitianPerKKTahunan['<?= $row["kk"] ?>'][<?= $row["tahun"] ?>]['<?= strtoupper($row["jenis"]) ?>'] = <?= $row["nPenelitian"] ?>;
    <?php endforeach ?>

    const dataPenelitianAnyKKTahunan = [
        {
            name: 'Eksternal',
            data: [<?php foreach ($getOrderByTahunEksternal as $cpub) {
                        echo '' . $cpub['jumlah_pen'] . ',';
                    } ?>]
        }, 
        {
        name: 'Internal',
        data: [<?php foreach ($getOrderByTahunInternal as $cpub) {
                    echo '' . $cpub['jumlah_pen'] . ',';
                } ?>]
        }, 
        {
            name: 'Mandiri',
            data: [<?php foreach ($getOrderByTahunMandiri as $cpub) {
                        echo '' . $cpub['jumlah_pen'] . ',';
                    } ?>]
        }, 
        {
            name: 'Kerja Sama PT',
            data: [<?php foreach ($getOrderByTahunKerjasamaPT as $cpub) {
                        echo '' . $cpub['jumlah_pen'] . ',';
                    } ?>]
        }, 
        {
            name: 'Hilirisasi',
            data: [<?php foreach ($getOrderByTahunHilirisasi as $cpub) {
                        echo '' . $cpub['jumlah_pen'] . ',';
                    } ?>]
        }, 
    ];

    const dataPenelitianAnyKind = {
        <?php foreach ($order_by_tahun_Asc as $obt) {
            echo '"' . $obt['thn']. '":' . $obt['jumlah_pen'] . ',';
        } ?>
    }

    const onDataPointSelection = function(e, context, opts) {
        let kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex]
        let targetElement = document.getElementById("chartPenelitianDosen") 
        updateChartStatistik(targetElement, kodeDosen)
    }
    
    function makeChartPenelitianPerTahun(targetElement, labels, values) {
        new ApexCharts( 
            targetElement,
            {
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
                series: [{ name: 'penelitian', data: values }],
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
                    labels: { show: false, formatter: val => val + " Penelitian" }
                },
            }
        ).render();
    }

    function makeChartPenelitianPerJenisTahunan(targetElement, labels, values) {
        new ApexCharts( 
            targetElement, 
            {
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
                    labels: { show: false, formatter: val => val + " Penelitian"}
                },

            }
        ).render();
    }

    function makeChartPenelitianPerDosen(targetElement, labels, values) {
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
                    data: values
                }],
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
                        formatter: val => val + " Penelitian"
                    }
                },
            }
        ).render();
    }

    function onPenelitianPerDosenFilterUpdate() {
        const {kk, tahun} = FILTER_PENELITIAN_PER_DOSEN;
        document.getElementById("chartPenelitianPerDosen__KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartPenelitianPerDosen__tahun").innerHTML = tahun;
        const targetElement = document.getElementById("chartPenelitianPerDosen");
        targetElement.innerHTML = "";

        const chartLabels = dosenByKK[kk];
        const chartValues = dosenByKK[kk].map(dosen => (
            Object.entries(dataPenelitian[dosen])
                .map((val, idx) => {
                    const [tahunPenelitian, nPenelitian] = val;
                    return tahun == "Semua" || tahunPenelitian == tahun ? nPenelitian: 0;
                })
                .reduce((acc, val) => acc + val, 0)
            )
        )

        makeChartPenelitianPerDosen( targetElement, chartLabels, chartValues);
    }

    function onPenelitianPerTahunFilterUpdate() {
        const {kk} = FILTER_PENELITIAN_PER_TAHUN;
        document.getElementById("chartPenelitianPerTahun__KK").innerHTML = `Semua`;
        let chartLabels = Object.keys(dataPenelitianAnyKind);
        let chartValues = Object.values(dataPenelitianAnyKind);

        if(kk != "") {
            document.getElementById("chartPenelitianPerTahun__KK").innerHTML = `KK ${kk}`;
            chartLabels = Object.keys(dataPenelitianPerKKTahunan[kk])
            chartValues = Object.values(dataPenelitianPerKKTahunan[kk])
                                .map(abdimasType => (
                                    Object.values(abdimasType)
                                          .reduce((acc, val) => acc + val, 0)
                                ))
        }

        const targetElement = document.getElementById("chartPenelitianPerTahun");
        targetElement.innerHTML = "";
        makeChartPenelitianPerTahun(targetElement, chartLabels, chartValues);

    }

    function onPenelitianPerJenisTahunanFilterUpdate() {
        const {kk} = FILTER_PENELITIAN_PER_JENIS_TAHUNAN;
        const chartLabels = [<?php foreach ($order_by_tahun_Asc as $cpub) {
                                echo '' . $cpub['thn'] . ',';
                            } ?>]   

        let chartValues = dataPenelitianAnyKKTahunan;
        document.getElementById("chartPenelitianPerJenisTahunan__KK").innerHTML = 'Semua';
        if(kk != "") {
            document.getElementById("chartPenelitianPerJenisTahunan__KK").innerHTML = `KK ${kk}`;
            chartValues = (
                displayedPenelitianTypes
                    .map(penelitianType => ({
                        name: penelitianType,
                        data: chartLabels
                                .map(penelitianYear => {
                                    penelitianPerYear = dataPenelitianPerKKTahunan[kk][penelitianYear]
                                    return (
                                        (
                                            penelitianPerYear == undefined ||
                                            penelitianPerYear[penelitianType] == undefined
                                        )
                                        ? 0: penelitianPerYear[penelitianType]
                                    )
                                })
                    }))
            )
        }

        const targetElement = document.getElementById("chartPenelitianPerJenisTahunan");
        targetElement.innerHTML = "";
        makeChartPenelitianPerJenisTahunan(targetElement, chartLabels, chartValues);
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
        )

        target.innerHTML = "";
        chart.render();
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
                    data: [<?php foreach ($count_publikasi as $cpub) {
                                echo '' . $cpub['jumlah_pen'] . ',';
                            } ?>]
                }],
                colors: BarchartBarColors,
                grid: { borderColor: '#f1f1f1', },
                xaxis: { categories: ['Eksternal', 'Hilirisasi', 'Internal', 'Kemitraan', 'Kerja Sama PT', 'Mandiri'], }
            }
        ).render();
    }

    // pie chart
    const PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        new ApexCharts( 
            document.getElementById("pie_chart"), 
            {
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
        ).render();
    }

    makeChartPenelitianPerTahun(
        document.getElementById("chartPenelitianPerTahun"),
        Object.keys(dataPenelitianAnyKind),
        Object.values(dataPenelitianAnyKind)
    )

    makeChartPenelitianPerJenisTahunan(
        document.getElementById("chartPenelitianPerJenisTahunan"),
        [<?php foreach ($getOrderByTahunEksternal as $cpub) {
            echo '' . $cpub['thn'] . ',';
        } ?>],
        dataPenelitianAnyKKTahunan
    )

    makeChartPenelitianPerDosen(
        document.getElementById("chartPenelitianPerDosen"),
        dosenByKK[Object.keys(dosenByKK)[0]],
        dosenByKK[Object.keys(dosenByKK)[0]].map(dosen => (
                                Object.values(dataPenelitian[dosen])
                                    .reduce((acc, val) => acc + val, 0)
                                ))
    )
</script>