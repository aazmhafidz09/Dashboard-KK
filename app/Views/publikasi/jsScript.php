<script type="text/javascript">
    $("document").ready(function() {
        $("#datatable").DataTable({
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/publikasi/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "judul_publikasi" },
                { data: "jenis" },
                { data: "nama_journal_conf" },
                { data: "akreditasi_journal_conf" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [ 
                            "penulis_1", 
                            "penulis_2", 
                            "penulis_3", 
                            "penulis_4", 
                            "penulis_5", 
                            "penulis_6", 
                            "penulis_7", 
                            "penulis_8", 
                            "penulis_9", 
                            "penulis_10", 
                            "penulis_11", 
                        ]
                            .map(columnName => row[columnName])
                            .filter(val => val.length > 0)
                            .join(", ")
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [
                            `<a href="publikasi/view/${row.id}">`,
                                "<i class='uil uil-eye font-size-18'></i>",
                            "</a>",
                        ].join(" ")
                    }
                }
            ]
        });
    })

    let FILTER_PUBLIKASI_PER_TAHUN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PUBLIKASI_PER_JENIS_TAHUNAN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PUBLIKASI_DOSEN = {
        kodeDosen: "",
        ketuaOnly: false
    }
    let FILTER_PUBLIKASI_PER_DOSEN = {
        recentPenulisPertamaOnly: false,
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
    };

    const displayedPublikasiTypes = [ "JURNAL INTERNASIONAL", "JURNAL NASIONAL" ,
                                    "PROSIDING INTERNASIONAL", "PROSIDING NASIONAL", ]
    const dataPublikasi = {
        <?php
            foreach($data_tahunan as $data) {
                echo "'" . $data["kode_dosen"] . "': {";
                foreach(array_keys($data) as $label) {
                    $pattern = "THN_";
                    $pos = strpos($label, $pattern);
                    if($pos !== false) {
                        $year = substr($label, $pos + strlen($pattern));
                        echo "'$year': " . $data[$pattern . $year] . ",";
                    }
                }
                echo "},";
            }
        ?>
    }

    const dosenByKK = { 
        <?php
            foreach($dosenByKK as $kkDosen => $dosenList) {
                echo "'$kkDosen': [";
                foreach($dosenList as $dosen) {
                    echo "'$dosen',";
                }
                echo "],";
            }
        ?> 
    };

    const dataPublikasiPerKKTahunan = {};
    Object.keys(dosenByKK)
        .forEach(kk  => { dataPublikasiPerKKTahunan[kk] = {} })

    const dataPenulisPertamaPerTahun = {
        <?php foreach($dosenPenulisPertamaPerTahun as $d => $annualData){
            echo "'$d': {";
            foreach($annualData as $year => $nPenulisPertama) {
                echo "$year: $nPenulisPertama, ";
            }
            echo "},";
        } ?>
    };

    let temp = [
        <?php foreach($annualPublikasiByTypeAndKK as $p) {
            $kk = $p["kk"];
            $tahun = $p["tahun"];
            $jenis = strtoupper($p["jenis"]);
            $nPublikasi = $p["nPublikasi"];
            echo "{'kk': '$kk' , 'tahun': $tahun, 'jenis': '$jenis', 'nPublikasi': $nPublikasi},";
        } ?>
    ];
    temp.forEach(data => {
        const {kk, tahun, jenis, nPublikasi} = data;
        if(!dataPublikasiPerKKTahunan[kk].hasOwnProperty(tahun)) {
            dataPublikasiPerKKTahunan[kk][tahun] = {};
        }
        
        dataPublikasiPerKKTahunan[kk][tahun][jenis] = nPublikasi;
    })

    const dataPublikasiAnyKKTahunan = [
        {
            name: 'Jurnal Internasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_jurnal_internasional'] . ',';
                    } ?>]
        }, 
        {
            name: 'Jurnal Nasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_jurnal_nasional'] . ',';
                    } ?>]
        }, 
        {
            name: 'Prosiding Internasional',
            data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                        echo '' . $cpub['jumlah_prosiding_internasional'] . ',';
                    } ?>]
        }, 
        {
            name: 'Prosiding Nasional',
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
        const kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex]

        if(kodeDosen != FILTER_PUBLIKASI_DOSEN.kodeDosen) {
            document.getElementById("dosenKetuaPublikasiToggle").checked = false;
            document.getElementById("dosenKetuaPublikasi") .style.display = "block";
            document.getElementById("chartPublikasi__desc").innerHTML = ""
            document.getElementById("chartPublikasi__title").innerHTML = `Statistik Publikasi ${kodeDosen}`

            FILTER_PUBLIKASI_DOSEN.kodeDosen = kodeDosen;
            FILTER_PUBLIKASI_DOSEN.ketuaOnly = false;

            const targetElement = document.getElementById("chartPublikasiDosen");
            const dataPublikasiDosen = dataPublikasi[kodeDosen];

            makeChartPublikasiDosen(targetElement, Object.keys(dataPublikasiDosen), Object.values(dataPublikasiDosen))
        }
    }

    function makeChartPublikasiPerTahun(targetElement, labels, values) {
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
                series: [{ name: 'publikasi', data: values }],
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
            }
        ).render();
    }

    function makeChartPublikasiPerJenisTahunan(targetElement, labels, values) {
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

    function makeChartPublikasiPerDosen(targetElement, labels, values) {
        targetElement.innerHTML = "";
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
                        formatter: val => val + ""
                    }
                },
            }
        ).render();
    }

    function makeChartPublikasiDosen(targetElement, labels, values) {
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
                series: [{ name: 'Publikasi', data: values }],
                grid: { borderColor: '#f1f1f1', },
                xaxis: {
                    categories: labels,
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
                        formatter: val => val + ""
                    }
                },
            }
        ) .render();

    }

    function makeSmallChart(targetElement, color) { // Minible's chart config
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
        makeChartPublikasiPerJenisTahunan(targetElement, chartLabels, chartValues);
    }

    function onPublikasiPerDosenFilterUpdate() {
        const {kk, tahun, recentPenulisPertamaOnly} = FILTER_PUBLIKASI_PER_DOSEN;
        document.getElementById("chartPublikasiPerDosen__KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartPublikasiPerDosen__tahun").innerHTML = tahun;

        const yearNow = (new Date()).getFullYear();
        const dosenList = dosenByKK[kk];
        let chartValues;

        if(recentPenulisPertamaOnly) {
            chartValues = dosenList.map(dosen => {
                const dataDosen = dataPenulisPertamaPerTahun[dosen]
                if(dataDosen == undefined) return 0;

                return Object.entries(dataDosen)
                    .map((val, idx) => {
                        const [tahunPublikasi, nPublikasi] = val;
                        const isRecent = (yearNow - tahunPublikasi < 4
                                            && yearNow - tahunPublikasi > -1)
                        return isRecent? nPublikasi: 0;
                    })
                    .reduce((acc, val) => acc + val, 0)
            })
        } else {
            chartValues = dosenList.map(dosen => {
                return Object.entries(dataPublikasi[dosen])
                    .map((val, idx) => {
                        const [tahunPublikasi, nPublikasi] = val;
                        const isRecent = (yearNow - tahunPublikasi < 4
                                            && yearNow - tahunPublikasi > -1)

                        if(tahun == "Recent" & isRecent) return nPublikasi;
                        return tahun == "Semua" || tahunPublikasi == tahun ? nPublikasi : 0
                    })
                    .reduce((acc, val) => acc + val, 0)
                }
            )
        }

        const targetElement = document.getElementById("chartPublikasiPerDosen");
        makeChartPublikasiPerDosen( targetElement, dosenList, chartValues)
    }

    function onPublikasiDosenFilterUpdate() {
        FILTER_PUBLIKASI_DOSEN.ketuaOnly = !FILTER_PUBLIKASI_DOSEN.ketuaOnly
        const {ketuaOnly, kodeDosen} = FILTER_PUBLIKASI_DOSEN
        const targetElement = document.getElementById("chartPublikasiDosen");

        const dataPublikasiDosen = dataPublikasi[kodeDosen];
        const chartLabels = Object.keys(dataPublikasiDosen);
        const chartValues = (
            (!ketuaOnly)
            ? Object.values(dataPublikasiDosen)
            : chartLabels.map(year => {
                    const publikasiDosen = dataPenulisPertamaPerTahun[kodeDosen]
                    if(publikasiDosen == undefined) return 0;

                    const nPublikasi = publikasiDosen[year];
                    return nPublikasi == undefined? 0: nPublikasi;
                })
        );

        makeChartPublikasiDosen(targetElement, chartLabels, chartValues);
    }

    function toggleRecentPenulisPertamaOnlyFilter() {
        const recentPenulisPertamaOnly = !FILTER_PUBLIKASI_PER_DOSEN.recentPenulisPertamaOnly;
        FILTER_PUBLIKASI_PER_DOSEN.recentPenulisPertamaOnly = recentPenulisPertamaOnly;

        const yearDropdown = document.getElementById("publikasiPerDosen__yearDropdown")
        yearDropdown.style.display = (recentPenulisPertamaOnly? "none": "block");
        onPublikasiPerDosenFilterUpdate();
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
    const pieChartValue = {
        <?php foreach($count_publikasi_all as $cpub) {
            echo "'" . strtoupper($cpub["jenis_pen"]) . "': " . $cpub["jumlah_pen"] . ",";
        } ?>
    }
    const PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        new ApexCharts( 
            document.getElementById("pie_chart"), 
            {
                chart: { height: 380, type: 'pie', },
                series: displayedPublikasiTypes.map(pType => pieChartValue[pType]),
                labels: displayedPublikasiTypes,
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
                    name: "Publikasi",
                    data: [<?php foreach ($akreditasi_jurnal as $cpub) {
                                echo '' . $cpub['jumlah_akr'] . ',';
                            } ?>]
                }],
                colors: BarchartBarColors,
                grid: { borderColor: '#f1f1f1', },
                xaxis: { 
                    categories: [<?php foreach ($akreditasi_jurnal as $cpub) {
                                    echo '"' . $cpub['akreditasi'] . '",';
                                } ?>], 
                },
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

    makeSmallChart( document.getElementById("smallChart__jurnalInternasional"), "#5b73e8")
    makeSmallChart( document.getElementById("smallChart__jurnalNasional"), "#20C997")
    makeSmallChart( document.getElementById("smallChart__prosidingInternasional"), "#f1b44c")
    makeSmallChart( document.getElementById("smallChart__prosidingNasional"), "#f46a6a")
</script>