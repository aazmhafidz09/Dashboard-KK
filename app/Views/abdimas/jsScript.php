<script type="text/javascript">
    $("document").ready(function() {
        $("#datatable").DataTable({
            destroy: true,
            pageLength: 5,
            ajax: {
                url: "/api/abdimas/list",
                dataSrc: ""
            },
            columns: [
                { data: "tahun" },
                { data: "jenis" },
                { data: "nama_kegiatan" },
                { data: "judul" }, 
                { data: "status" },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return [ 
                            "ketua", 
                            "anggota_1", 
                            "anggota_2", 
                            "anggota_3", 
                            "anggota_4", 
                            "anggota_5", 
                            "anggota_6", 
                            "anggota_7", 
                            "anggota_8", 
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
                            `<a href="abdimas/view/${row.id}">`,
                                "<i class='uil uil-eye font-size-18'></i>",
                            "</a>",
                        ].join(" ")
                    }
                }
            ]
        });
    })

    let FILTER_ABDIMAS_PER_TAHUN = { kk: <?= $defaultFilterKK ?>, }
    let FILTER_ABDIMAS_PER_JENIS_TAHUNAN = { kk: <?= $defaultFilterKK ?> }
    let FILTER_ABDIMAS_PER_DOSEN = { kk: <?= $defaultFilterKK ?>, tahun: "Semua"};
    let FILTER_ABDIMAS_DOSEN = { kodeDosen: "", status: "Semua"};

    const dataAbdimas = {
        <?php foreach($data_tahunan as $d) {
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
        } ?>
    }

    const dosenByKK = { 
        <?php foreach($dosenByKK as $kkDosen => $dosenList) {
            echo "'" . $kkDosen . "'" . ": [";
            foreach($dosenList as $dosen) {
                echo "'" . $dosen . "'" . ", ";
            }
            echo "],";
        } ?> 
    };

    const dataAbdimasPerKKTahunan = {};
    Object.keys(dosenByKK)
        .forEach(kk => { dataAbdimasPerKKTahunan[kk] = {} });

    const annualPerDosenByStatus = {
        <?php foreach($annualPerDosenByStatus as $status => $statusPerDosen) {
            echo "'$status': {";
            foreach($statusPerDosen as $dosen => $annualData) {
                echo "'$dosen': {";
                foreach($annualData as $year => $nAbdimas) {
                    echo "'$year': $nAbdimas,";
                }
                echo "},";
            }
            echo "},";
        } ?>
    }

    let temp = [ 
        <?php foreach($annualAbdimasByTypeAndKK as $row) {
            $kk = $row['kk']; 
            $tahun = $row['tahun']; 
            $jenis = strtoupper($row['jenis']);
            $nAbdimas = $row['nAbdimas'];
            echo "{'kk': '$kk' , 'tahun': $tahun, 'jenis': '$jenis', 'nAbdimas': $nAbdimas},";
        } ?>
    ]
    temp.forEach(data => {
        const {kk, tahun, jenis, nAbdimas} = data; 
        if(!dataAbdimasPerKKTahunan[kk].hasOwnProperty(tahun)) {
            dataAbdimasPerKKTahunan[kk][tahun] = {};
        }
        
        dataAbdimasPerKKTahunan[kk][tahun][jenis] = nAbdimas;
    })

    const dataAbdimasAnyKKTahunan = [
        {
            name: 'Internal',
            data: [<?php foreach ($order_jenis as $cpub) {
                        echo '' . $cpub['jumlah_Internal'] . ',';
                    } ?>]
        }, 
        {
            name: 'Eksternal',
            data: [<?php foreach ($order_jenis as $cpub) {
                        echo '' . $cpub['jumlah_Eksternal'] . ',';
                    } ?>]
        },
    ];

    const dataAbdimasAnyKind = { 
        <?php foreach ($order_by_tahun_desc as $obt) {
            echo '"' .  $obt['thn'] . '":' . $obt['jumlah_abd'] . ',';
        } ?> 
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

    function makeChartAbdimasPerJenisTahunan(targetElement, labels, values) {
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
                    labels: { show: false, formatter: val =>  val + "" }
                },
            }
        ).render();
    }

    function makeChartAbdimasPerTahun(targetElement, labels, values) {
        new ApexCharts(
            targetElement, 
            {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false, }
                },
                plotOptions: {
                    bar: { dataLabels: { position: 'top',} } // top, center, bottom
                },
                dataLabels: {
                    enabled: true,
                    position: 'top', // top, center, bottom,
                    formatter: val => val + "",
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#304758"] }
                },
                series: [{ name: 'Abdimas', data: values }],
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

    function makeChartAbdimasPerDosen(targetElement, labels, values) {
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
                series: [{ name: 'Abdimas', data: values }],
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

    function makeChartAbdimasDosen(targetElement, labels, values) {
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
                    bar: {
                        dataLabels: { position: 'top',}
                    }
                },
                dataLabels: {
                    enabled: true,
                    position: 'top', // top, center, bottom,
                    formatter: val => val + "",
                    offsetY: -20,
                    style: { fontSize: '12px', colors: ["#304758"] }
                },
                series: [{ name: 'Abdimas', data: values }],
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
                    labels: { show: false, formatter: val => val + "" }
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
        const kodeDosen = opts.w.config.xaxis.categories[opts.dataPointIndex]
        const targetElement = document.getElementById("chartAbdimasDosen") 
        FILTER_ABDIMAS_DOSEN = { kodeDosen: kodeDosen, status: "Semua" }

        document.getElementById("chartAbdimas__desc").innerHTML = "";
        document.getElementById("chartAbdimas__title").innerHTML = `Statistik Abdimas ${kodeDosen}`;
        document.getElementById("chartAbdimasDosen__status").innerHTML = `Semua`;
        document.getElementById("abdimasDosenFilter").style.display = "block";

        const dataAbdimasDosen = dataAbdimas[kodeDosen];
        makeChartAbdimasDosen(
            targetElement, 
            Object.keys(dataAbdimasDosen),
            Object.values(dataAbdimasDosen))
    }

    function onAbdimasDosenFilterUpdate() {
        const {kodeDosen, status} = FILTER_ABDIMAS_DOSEN;
        const dataAbdimasDosen = dataAbdimas[kodeDosen];
        const targetElement = document.getElementById("chartAbdimasDosen") 
        
        const labels = Object.keys(dataAbdimasDosen);
        let values = Object.values(dataAbdimasDosen);
        if(status != "Semua") {
            values = labels.map(year => {
                const annualData = annualPerDosenByStatus[status][kodeDosen]
                if(annualData == undefined) return 0;

                const yearData = annualData[year];
                return yearData == undefined? 0: yearData;
            });
        }

        document.getElementById("chartAbdimasDosen__status").innerHTML = status;
        makeChartAbdimasDosen(targetElement, labels, values)
    }

    function onAbdimasPerDosenFilterUpdate() {
        const {kk, tahun} = FILTER_ABDIMAS_PER_DOSEN;
        document.getElementById("chartAbdimasPerDosen__KK").innerHTML = `KK ${kk}`;
        document.getElementById("chartAbdimasPerDosen__tahun").innerHTML = tahun;

        const chartLabels = dosenByKK[kk];
        const chartValues = dosenByKK[kk].map(dosen => (
            Object.entries(dataAbdimas[dosen])
                .map((val, idx) => {
                    const [tahunAbdimas, nAbdimas] = val;
                    return tahun == "Semua" || tahunAbdimas == tahun ? nAbdimas: 0;
                })
                .reduce((acc, val) => acc + val, 0)
            )
        )

        const targetElement = document.getElementById("chartAbdimasPerDosen");
        targetElement.innerHTML = "";
        makeChartAbdimasPerDosen(targetElement, chartLabels, chartValues);
    }

    function onAbdimasPerTahunFilterUpdate() {
        const {kk} = FILTER_ABDIMAS_PER_TAHUN;
        document.getElementById("chartAbdimasPerTahun__KK").innerHTML = `Semua`;
        let chartLabels = Object.keys(dataAbdimasAnyKind);
        let chartValues = Object.values(dataAbdimasAnyKind);

        if(kk != "") {
            document.getElementById("chartAbdimasPerTahun__KK").innerHTML = `KK ${kk}`;
            chartLabels = Object.keys(dataAbdimasPerKKTahunan[kk])
            chartValues = Object.values(dataAbdimasPerKKTahunan[kk])
                                .map(abdimasType => (
                                    Object.values(abdimasType)
                                          .reduce((acc, val) => acc + val, 0)
                                ))
        }

        const targetElement = document.getElementById("chartAbdimasTahunan");
        targetElement.innerHTML = "";
        makeChartAbdimasPerTahun(targetElement, chartLabels, chartValues);
    }

    function onAbdimasPerJenisTahunanFilterUpdate() {
        const {kk} = FILTER_ABDIMAS_PER_JENIS_TAHUNAN;
        document.getElementById("chartAbdimasPerJenisTahunan__KK").innerHTML = 'Semua';

        const chartLabels = [ <?php foreach ($order_jenis as $cpub) {
                                echo '' . $cpub['tahun'] . ',';
                            } ?>] ;
        let chartValues = dataAbdimasAnyKKTahunan;
        if(kk != '') {
            document.getElementById("chartAbdimasPerJenisTahunan__KK").innerHTML = `KK ${kk}`;
            chartValues = [
                {
                    name: 'Internal',
                    data: Object.values(dataAbdimasPerKKTahunan[kk]).map(dataTahunan => {
                        const nAbdimasEksternal = dataTahunan["Internal"]
                        return nAbdimasEksternal == undefined? 0: nAbdimasEksternal;
                    })
                }, {
                    name: 'Eksternal',
                    data: Object.values(dataAbdimasPerKKTahunan[kk]).map(dataTahunan => {
                        const nAbdimasEksternal = dataTahunan["Eksternal"]
                        return nAbdimasEksternal == undefined? 0: nAbdimasEksternal;
                    })
                },
            ];
        }

        const targetElement = document.getElementById("chartAbdimasPerJenisTahunan");
        targetElement.innerHTML = "";
        makeChartAbdimasPerJenisTahunan(targetElement, chartLabels, chartValues);
    }

    const PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        new ApexCharts( document.getElementById("pie_chart"), {
            chart: { height: 380, type: 'pie', },
            series: [<?php echo $Abdimas_Inter ?>, <?php echo $Abdimas_Ekster ?>],
            labels: ["Internal", "Eksternal"],
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
        }).render();
    }

    makeChartAbdimasPerTahun(
        document.getElementById("chartAbdimasTahunan"),
        Object.keys(dataAbdimasAnyKind),
        Object.values(dataAbdimasAnyKind) 
    );
    makeChartAbdimasPerJenisTahunan(
        document.getElementById("chartAbdimasPerJenisTahunan"),
        [ <?php foreach ($order_jenis as $cpub) {
            echo '' . $cpub['tahun'] . ',';
        } ?>],
        dataAbdimasAnyKKTahunan
    );
    makeChartAbdimasPerDosen(
        document.getElementById("chartAbdimasPerDosen"),
        dosenByKK[Object.keys(dosenByKK)[0]],
        dosenByKK[Object.keys(dosenByKK)[0]].map(dosen => (
                                Object.values(dataAbdimas[dosen])
                                    .reduce((acc, val) => acc + val, 0)
                                ))
    );

    makeSmallChart( document.getElementById("smallChart__internal"), "#5b73e8")
    makeSmallChart( document.getElementById("smallChart__eksternal"), "#20C997")
</script>