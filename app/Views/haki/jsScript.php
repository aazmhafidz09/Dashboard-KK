<script type="text/javascript">
    $("document").ready(function() {
        $("#datatable").DataTable({
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/haki/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "jenis" },
                { data: "judul" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [ "ketua", 
                            "anggota_1", 
                            "anggota_2", 
                            "anggota_3", 
                            "anggota_4", 
                            "anggota_5", 
                            "anggota_6", 
                            "anggota_7", 
                            "anggota_8", 
                            "anggota_9", 
                        ]
                            .map(columnName => row[columnName])
                            .filter(val => val.length > 0)
                            .join(", ")
                    }
                },
                { data: "no_pendaftaran" },
                { data: "no_sertifikat" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [
                            `<a href="haki/view/${row.id}">`,
                                "<i class='uil uil-eye font-size-18'></i>",
                            "</a>",
                        ].join(" ")
                    }
                }
            ]
        });
    })

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

    const dataHakiPerKKTahunan = {};
    Object.keys(dosenByKK)
        .forEach(kk => { dataHakiPerKKTahunan[kk] = {} });

    let temp = [ 
        <?php foreach($annualHakiByTypeAndKK as $row) {
            $kk = $row['kk']; 
            $tahun = $row['tahun']; 
            $jenis = strtoupper($row['jenis']);
            $nHaki = $row['nHaki'];
            echo "{'kk': '$kk' , 'tahun': $tahun, 'jenis': '$jenis', 'nHaki': $nHaki},";
        } ?>
    ]
    temp.forEach(data => {
        const {kk, tahun, jenis, nHaki} = data; 
        if(!dataHakiPerKKTahunan[kk].hasOwnProperty(tahun)) {
            dataHakiPerKKTahunan[kk][tahun] = {};
        }
        
        dataHakiPerKKTahunan[kk][tahun][jenis] = nHaki;
    })

    const onDataPointSelection = function(e, context, opts) {
        const kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex];
        if(kodeDosen != FILTER_HAKI_DOSEN.kodeDosen) {
            FILTER_HAKI_DOSEN.kodeDosen = kodeDosen;
            document.getElementById("chartHaki__desc").innerHTML = ""
            document.getElementById("chartHaki__title").innerHTML = `Statistik Haki ${kodeDosen}`

            const targetElement = document.getElementById("chartHakiDosen");
            const dataHakiDosen = dataHaki[kodeDosen];
            makeChartHakiDosen(
                targetElement, 
                Object.keys(dataHakiDosen), 
                Object.values(dataHakiDosen))
        }
    }

    function makeChartHakiPerTahun(targetElement, labels, values) {
        targetElement.innerHTML = "";
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
        targetElement.innerHTML = "";
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
        targetElement.innerHTML = "";
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

    function makeSmallChart(targetElement, color) { // Minible's chart config
        targetElement.innerHTML = "";
        new ApexCharts(
            targetElement, 
            {
                series:[{
                    name: "",
                    data: Array.from({length: 11}, (_, idx) => 12 + (Math.floor(Math.random()*71) % 50)),
                }],
                fill: {colors: color},
                chart: {
                    type:"bar",
                    width:70,
                    height:40,
                    sparkline:{enabled:!0}
                },
                plotOptions: {
                    bar:{columnWidth:"50%"}
                },
                labels:[1,2,3,4,5,6,7,8,9,10,11],
                xaxis:{crosshairs:{width:1}},
                tooltip:{fixed:{enabled:!1},
                x:{show:!1},
                y:{title:{formatter:function(r){return""}}},
                marker:{show:!1}}
            }
        ).render()
    }

    function onHakiPerDosenFilterUpdate() {
        const {kk, tahun} = FILTER_HAKI_PER_DOSEN;
        const yearNow = (new Date()).getFullYear(); // Inclusive with system's year
        const filterTahunText = document.getElementById("chartHakiPerDosen__tahun")

        document.getElementById("chartHakiPerDosen__KK").innerHTML = `KK ${kk}`;
        filterTahunText.innerHTML = ((tahun == "Recent")
                                        ? `(${yearNow - 3} - ${yearNow})`
                                        : tahun);

        const dosenList = dosenByKK[kk]
        const chartValues = dosenList.map(dosen => (
            Object.entries(dataHaki[dosen])
                .map((val, idx) => {
                    const [tahunHaki, nHaki] = val;
                    const isRecent = (yearNow - tahunHaki < 4
                                        && yearNow - tahunHaki > -1)

                    if(tahun == "Recent" & isRecent) return nHaki;
                    return tahun == "Semua" || tahunHaki == tahun? nHaki: 0;
                })
                .reduce((acc, val) => acc + val, 0)
            )
        )

        const targetElement = document.getElementById("chartHakiPerDosen");
        makeChartHakiPerDosen(targetElement, dosenList, chartValues);
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
                chart: { height: 380, type: 'pie', },
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

    makeSmallChart( document.getElementById("smallChart__hakCipta"), "#5b73e8")
    makeSmallChart( document.getElementById("smallChart__paten"), "#20C997")
    makeSmallChart( document.getElementById("smallChart__merek"), "#f1b44c")
    makeSmallChart( document.getElementById("smallChart__desainIndustri"), "#f46a6a")
</script>