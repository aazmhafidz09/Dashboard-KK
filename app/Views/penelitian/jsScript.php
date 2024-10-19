<script type="text/javascript">
    $("document").ready(function() {
        $("#datatable").DataTable({
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/penelitian/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "nama_kegiatan" },
                { data: "judul_penelitian" },
                { data: "jenis" }, 
                { data: "status" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [ 
                            "ketua_peneliti", 
                            "anggota_peneliti_1", 
                            "anggota_peneliti_2", 
                            "anggota_peneliti_3", 
                            "anggota_peneliti_4", 
                            "anggota_peneliti_5", 
                            "anggota_peneliti_6", 
                            "anggota_peneliti_7", 
                            "anggota_peneliti_8", 
                            "anggota_peneliti_9", 
                            "anggota_peneliti_10", 
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
                            `<a href="penelitian/view/${row.id}">`,
                                "<i class='uil uil-eye font-size-18'></i>",
                            "</a>",
                        ].join(" ")
                    }
                }
            ]
        });
    })

    let FILTER_PENELITIAN_PER_TAHUN = { kk: <?= $defaultFilterKK ?>, }
    let FILTER_PENELITIAN_PER_JENIS_TAHUNAN = { kk: <?= $defaultFilterKK ?>}
    let FILTER_PENELITIAN_PER_DOSEN = {
        kk: <?= $defaultFilterKK ?>,
        tahun: "Semua",
        recentKetuaOnly: false,
    };
    let FILTER_PENELITIAN_DOSEN = {
        kodeDosen: "",
        ketuaOnly: false
    }

    const dataPenelitian = {
        <?php
            foreach($data_tahunan as $d) {
                echo "'" . $d["kode_dosen"] . "': {";
                foreach(array_keys($d) as $label) {
                    $pattern = "THN_";
                    $pos = strpos($label, $pattern);
                    if($pos !== false) {
                        $year = substr($label, $pos + strlen($pattern));
                        echo "'$year': " . $d[$pattern . $year] . ",";
                    }
                }
                echo "},";
            }
        ?>
    }

    const dosenByKK = { 
        <?php foreach($dosenByKK as $kkDosen => $dosenList) {
                echo "'$kkDosen':[";
                foreach($dosenList as $dosen) {
                    echo "'$dosen',";
                }
                echo "],";
        } ?> 
    };

    const availablePenelitianYears = [ 
        <?php foreach($availablePenelitianYear as $y): echo "$y,"; endforeach ?>
    ].sort()

    const dataPenelitianPerKKTahunan = {};
    Object.keys(dosenByKK)
        .forEach(kk => { dataPenelitianPerKKTahunan[kk] = {} })

    let temp = [ 
        <?php foreach($annualPenelitianByTypeAndKK as $row) {
            $kk = $row['kk']; 
            $tahun = $row['tahun']; 
            $jenis = strtoupper($row['jenis']);
            $nPenelitian = $row['nPenelitian'];
            echo "{'kk': '$kk' , 'tahun': $tahun, 'jenis': '$jenis', 'nPenelitian': $nPenelitian},";
        } ?>
    ]
    temp.forEach(data => {
        const {kk, tahun, jenis, nPenelitian} = data; 
        if(!dataPenelitianPerKKTahunan[kk].hasOwnProperty(tahun)) {
            dataPenelitianPerKKTahunan[kk][tahun] = {};
        }
        
        dataPenelitianPerKKTahunan[kk][tahun][jenis] = nPenelitian;
    })

    const displayedPenelitianTypes = [ "INTERNAL", "EKSTERNAL", "MANDIRI", 
                                    "KERJASAMA PERGURUAN TINGGI", "HILIRISASI"];
    const penelitianTypes = [
        <?php foreach($penelitianTypes as $type) {
            echo "'$type',";
        } ?>
    ];
    temp = Object.fromEntries(penelitianTypes.map(pType => [pType, {}]))
    <?php foreach($annualPenelitianByType as $row): ?>
        <?php if(strtoupper($row["jenis"]) != "KEMITRAAN"): ?>
            temp['<?= strtoupper($row["jenis"]) ?>'][<?= $row["tahun"] ?>] = <?= $row["nPenelitian"] ?>;
        <?php endif ?>
    <?php endforeach ?>

    const dataPenelitianPerJenisTahunan = (
        displayedPenelitianTypes
            .map(penelitianType => ({
                name: penelitianType,
                data: availablePenelitianYears 
                        .map(penelitianYear => {
                            const penelitianPerType = temp[penelitianType];
                            if(penelitianPerType == undefined) return 0;

                            const penelitianPerYear = penelitianPerType[penelitianYear];
                            return (penelitianPerYear == undefined? 0: penelitianPerYear)
                        })
            }))
    )

    const dataPenelitianAnyKind = {
        <?php foreach ($order_by_tahun_Asc as $obt) {
            echo '"' . $obt['thn']. '":' . $obt['jumlah_pen'] . ',';
        } ?>
    }

    const dataKetuaPenelitianPerTahun = {
        <?php foreach($dosenKetuaByYear as $d => $annualData){
            echo "'$d': {";
            foreach($annualData as $year => $nKetua) {
                echo "$year: $nKetua, ";
            }
            echo "},";
        } ?>
    };

    function makeChartPenelitianPerTahun(targetElement, labels, values) {
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
                    bar: { dataLabels: { position: 'top', }, } // top, center, bottom
                },
                dataLabels: {
                    enabled: true,
                    position: 'top', // top, center, bottom,
                    formatter: val => val + "",
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#304758"] }
                },
                series: [{ name: 'Penelitian', data: values }],
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

    function makeChartPenelitianPerJenisTahunan(targetElement, labels, values) {
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
                    labels: { show: false, formatter: val => val + ""}
                },
            }
        ).render();
    }

    function makeChartPenelitianPerDosen(targetElement, labels, values) {
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
                    name: 'Penelitian',
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
                        formatter: val => val + ""
                    }
                },
            }
        ).render();
    }

    function makeChartPenelitianDosen(targetElement, labels, values) {
        targetElement.innerHTML = "";
        new ApexCharts(
            targetElement,  
            {
                chart: {
                    // animations: { enabled: false },
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
                series: [{ name: 'Penelitian', data: values }],
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

    const onDataPointSelection = function(e, context, opts) {
        const kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex];

        if(kodeDosen != FILTER_PENELITIAN_DOSEN.kodeDosen) {
            document.getElementById("dosenKetuaPenelitianToggle").checked = false;
            document.getElementById("dosenKetuaPenelitian") .style.display = "block";
            document.getElementById("chartPenelitian__desc").innerHTML = ""
            document.getElementById("chartPenelitian__title").innerHTML = `Statistik Penelitian ${kodeDosen}`

            FILTER_PENELITIAN_DOSEN.kodeDosen = kodeDosen;
            FILTER_PENELITIAN_DOSEN.ketuaOnly = false;
            const targetElement = document.getElementById("chartPenelitianDosen");
            const dataPublikasiDosen = dataPenelitian[kodeDosen];
            makeChartPenelitianDosen(targetElement, Object.keys(dataPublikasiDosen), Object.values(dataPublikasiDosen))
        }
    }
    
    function onPenelitianPerDosenFilterUpdate() {
        const {kk, tahun, recentKetuaOnly} = FILTER_PENELITIAN_PER_DOSEN;
        const yearNow = (new Date()).getFullYear(); // Inclusive with system's year
        const filterTahunText = document.getElementById("chartPenelitianPerDosen__tahun")

        document.getElementById("chartPenelitianPerDosen__KK").innerHTML = `KK ${kk}`;
        filterTahunText.innerHTML = ((tahun == "Recent")
                                        ? `(${yearNow - 3} - ${yearNow})`
                                        : tahun);

        const dosenList = dosenByKK[kk];
        let chartValues;
        if(recentKetuaOnly) {
            chartValues = dosenList.map(dosen => {
                const dataDosen = dataKetuaPenelitianPerTahun[dosen]
                if(dataDosen == undefined) return 0;

                return Object.entries(dataDosen)
                    .map((val, idx) => {
                        const [tahunPenelitian, nPenelitian] = val;
                        const isRecent = (yearNow - tahunPenelitian < 4
                                            && yearNow - tahunPenelitian > -1)
                        return isRecent? nPenelitian: 0;
                    })
                    .reduce((acc, val) => acc + val, 0)
            })
        } else {
            chartValues = dosenList.map(dosen => {
                return Object.entries(dataPenelitian[dosen])
                    .map((val, idx) => {
                        const [tahunPenelitian, nPenelitian] = val;
                        const isRecent = (yearNow - tahunPenelitian < 4
                                            && yearNow - tahunPenelitian > -1)

                        if(tahun == "Recent" & isRecent) return nPenelitian;
                        return tahun == "Semua" || tahunPenelitian == tahun ? nPenelitian: 0;
                    })
                    .reduce((acc, val) => acc + val, 0)
            })
        }

        const targetElement = document.getElementById("chartPenelitianPerDosen");
        makeChartPenelitianPerDosen(targetElement, dosenList, chartValues);
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
                                .map(penType => (
                                    Object.values(penType)
                                          .reduce((acc, val) => acc + val, 0)
                                ))
        }

        const targetElement = document.getElementById("chartPenelitianPerTahun");
        makeChartPenelitianPerTahun(targetElement, chartLabels, chartValues);

    }

    function onPenelitianPerJenisTahunanFilterUpdate() {
        const {kk} = FILTER_PENELITIAN_PER_JENIS_TAHUNAN;
        const chartLabels = [<?php foreach ($order_by_tahun_Asc as $cpub) {
                                echo '' . $cpub['thn'] . ',';
                            } ?>]   

        document.getElementById("chartPenelitianPerJenisTahunan__KK").innerHTML = `Semua`;
        let chartValues = dataPenelitianPerJenisTahunan
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
                                        ( penelitianPerYear == undefined 
                                            || penelitianPerYear[penelitianType] == undefined)
                                        ? 0: penelitianPerYear[penelitianType]
                                    )
                                })
                    })))
        }

        const targetElement = document.getElementById("chartPenelitianPerJenisTahunan");
        makeChartPenelitianPerJenisTahunan(targetElement, chartLabels, chartValues);
    }

    function onPenelitianDosenFilterUpdate() {
        FILTER_PENELITIAN_DOSEN.ketuaOnly = !FILTER_PENELITIAN_DOSEN.ketuaOnly;
        const {kodeDosen, ketuaOnly} = FILTER_PENELITIAN_DOSEN;
        const targetElement = document.getElementById("chartPenelitianDosen");

        const dataPenelitianDosen = dataPenelitian[kodeDosen];
        const chartLabels = Object.keys(dataPenelitianDosen);
        const chartValues = (
            (!ketuaOnly)
            ? Object.values(dataPenelitianDosen)
            : chartLabels.map(year => {
                    const penelitianDosen = dataKetuaPenelitianPerTahun[kodeDosen]
                    if(penelitianDosen == undefined) return 0;

                    const nPenelitian = penelitianDosen[year];
                    return nPenelitian == undefined? 0: nPenelitian;
                })
        );
        makeChartPenelitianDosen(targetElement, chartLabels, chartValues);
    }

    function toggleRecentKetuaOnlyFilter() {
        const recentKetuaOnly = !FILTER_PENELITIAN_PER_DOSEN.recentKetuaOnly;
        FILTER_PENELITIAN_PER_DOSEN.recentKetuaOnly = recentKetuaOnly;

        const yearDropdown = document.getElementById("penelitianPerDosen__yearDropdown")
        yearDropdown.style.display = (recentKetuaOnly? "none": "block");
        onPenelitianPerDosenFilterUpdate();
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
                    name: "Penelitian",
                    data: [<?php foreach ($count_publikasi as $cpub) {
                                echo '' . $cpub['jumlah_pen'] . ',';
                            } ?>]
                }],
                colors: BarchartBarColors,
                grid: { borderColor: '#f1f1f1', },
                xaxis: { 
                    categories: [<?php foreach ($count_publikasi as $cpub) {
                                echo '"' . $cpub['jenis_pen'] . '",';
                                } ?>], 
                }
            }
        ).render();
    }

    // pie chart
    const pieChartValues = {
        <?php foreach($count_publikasi as $cpub) {
            echo "'" . strtoupper($cpub["jenis_pen"]) . "': " . $cpub['jumlah_pen'] . ",";
        } ?>
    }
    const PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        new ApexCharts( 
            document.getElementById("pie_chart"), 
            {
                chart: { height: 380, type: 'pie', },
                series: displayedPenelitianTypes.map(pTypes => pieChartValues[pTypes]),
                labels: displayedPenelitianTypes,
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
        availablePenelitianYears,
        dataPenelitianPerJenisTahunan
    )

    makeChartPenelitianPerDosen(
        document.getElementById("chartPenelitianPerDosen"),
        dosenByKK[Object.keys(dosenByKK)[0]],
        dosenByKK[Object.keys(dosenByKK)[0]].map(dosen => (
                                Object.values(dataPenelitian[dosen])
                                    .reduce((acc, val) => acc + val, 0)
                                ))
    )

    makeSmallChart( document.getElementById("smallChart__eksternal"), "#5b73e8")
    makeSmallChart( document.getElementById("smallChart__internal"), "#20C997")
    makeSmallChart( document.getElementById("smallChart__mandiri"), "#f1b44c")
    makeSmallChart( document.getElementById("smallChart__kerjasamaPT"), "#f46a6a")
    makeSmallChart( document.getElementById("smallChart__hilirisasi"), "#6f42c1")
</script>