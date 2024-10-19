<?= $this->include('partials/main') ?>

<head>
    <?= $this->include('partials/head-css') ?>
</head>

<?= $this->include('partials/body') ?>

<!-- Begin page -->
<div id="layout-wrapper">
    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('warning')) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= session()->getFlashdata('warning'); ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif ?>
                <div class="row mb-3">
                    <div class="col-md-6 col-xl-3 mb-xl-0 mb-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__publikasi" style="min-height: 40px; min-width: 70px;"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $count_publikasi ?></span></h4>
                                    <p class="text-muted mb-0">Total Publikasi</p>
                                </div>

                                <?php if ($peningkatan_publikasi >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_publikasi ?> Publikasi</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_publikasi ?> Publikasi</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3 mb-xl-0 mb-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__penelitian" style="min-height: 40px; min-width: 70px;"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $count_penelitian ?></span></h4>
                                    <p class="text-muted mb-0">Total Penelitian</p>
                                </div>
                                <?php if ($peningkatan_penelitian >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_penelitian ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_penelitian ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3 mb-xl-0 mb-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__abdimas" style="min-height: 40px; min-width: 70px;"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $count_abdimas ?></span></h4>
                                    <p class="text-muted mb-0">Total Abdimas</p>
                                </div>
                                <?php if ($peningkatan_abdimas >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_abdimas ?> Abdimas</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_abdimas ?> Abdimas</span> dari tahun sebelumnya
                                    </p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3 mb-xl-0 mb-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__haki" style="min-height: 40px; min-width: 70px;"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"> <span data-plugin="counterup"><?php echo $count_haki ?></span></h4>
                                    <p class="text-muted mb-0">Total HaKi</p>
                                </div>

                                <?php if ($peningkatan_haki >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_haki ?> HaKi</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_haki ?> HaKi</span> dari tahun sebelumnya
                                    </p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->


                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="fw-semibold" href="./publikasi">Lihat Lengkap</a>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Publikasi</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <!-- <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup">137</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Publikasi</span></h3>
                                        </li> -->
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Publikasi_Inter ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Jurnal Internasional</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Publikasi_Nas ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Jurnal Nasional</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Publikasi_Pros ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Prosiding Internasional</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Publikasi_Pros_Nas ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Prosiding Nasional</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="column_chart" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-4">Publikasi Dosen</h4>
                                    <div class="float-end">
                                        <label for="publikasiDosen"> Ascending &nbsp;</label>
                                        <input id="publikasiDosen" type="checkbox" onchange="onPublikasiDosenToggle()">
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 450px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody id="tPublikasiDosen">
                                                <?php foreach ($nPublikasiEachDosen as $tp) : ?>
                                                    <tr>
                                                        <td>
                                                            <a href="/dosen/<?=$tp['kode_dosen']?>">
                                                                <strong class="font-size-15 mb-1 fw-normal text-black"><?= $tp['kode_dosen']; ?></strong>
                                                                <p class="text-muted font-size-13 mb-0"> <?=
                                                                    ((strlen($tp['nama_dosen']) <= 15)
                                                                    ? $tp['nama_dosen']
                                                                    : substr($tp['nama_dosen'], 0, 15) . "...")
                                                                    ?>
                                                                </p>
                                                            </a>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end">
                                                            <i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>
                                                            <?= $tp['nPublikasi']; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                </div> <!-- data-sidebar-->
                            </div><!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end Col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown"> <a class="fw-semibold" href="./penelitian">Lihat Lengkap</a> </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Penelitian</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_Inter ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Eksternal</span> </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_Ekster ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Internal</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_Mand ?></span><span class="text-muted d-inline-block font-size-15 ms-3">mandiri</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_kerjasamaPT ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Kerjasama PT</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_Hilir ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Hilirisasi</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="column_chart_datalabel" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-4">Penelitian Dosen</h4>
                                    <div class="float-end">
                                        <label for="penelitianDosen"> Ascending &nbsp;</label>
                                        <input id="penelitianDosen" type="checkbox" onchange="onPenelitianDosenToggle()">
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody id="tPenelitianDosen">
                                                <?php foreach ($nPenelitianEachDosen as $tp) : ?>
                                                    <tr>
                                                        <td style="max-width: 40%;">
                                                            <a href="/dosen/<?=$tp['kode_dosen']?>">
                                                                <strong class="font-size-15 mb-1 fw-normal text-black"><?= $tp['kode_dosen']; ?></strong>
                                                                <p class="text-muted font-size-13 mb-0"> <?=
                                                                    ((strlen($tp['nama_dosen']) <= 15)
                                                                    ? $tp['nama_dosen']
                                                                    : substr($tp['nama_dosen'], 0, 15) . "...")
                                                                    ?>
                                                                </p>
                                                            </a>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end">
                                                            <?= $tp['nPenelitian']; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="fw-semibold" href="./abdimas">Lihat Lengkap</a>

                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Abdimas</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup"><?php echo $count_abdimas ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Total Abdimas</span></h3>
                                        </li>

                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="column_chart_datalabel_abdimas" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-4"> Abdimas Dosen</h4>
                                    <div class="float-end">
                                        <label for="abdimasDosen"> Ascending &nbsp;</label>
                                        <input id="abdimasDosen" type="checkbox" onchange="onAbdimasDosenToggle()">
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody id="tAbdimasDosen">
                                                <?php foreach ($nAbdimasEachDosen as $tp) : ?>
                                                    <tr>
                                                        <td style="max-width: 40%;">
                                                            <a href="/dosen/<?=$tp['kode_dosen']?>">
                                                                <strong class="font-size-15 mb-1 fw-normal text-black"><?= $tp['kode_dosen']; ?></strong>
                                                                <p class="text-muted font-size-13 mb-0"> <?=
                                                                    ((strlen($tp['nama_dosen']) <= 15)
                                                                    ? $tp['nama_dosen']
                                                                    : substr($tp['nama_dosen'], 0, 15) . "...")
                                                                    ?>
                                                                </p>
                                                            </a>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end">
                                                            <?= $tp['nAbdimas']; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="fw-semibold" href="./haki">Lihat Lengkap</a>

                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik HaKi</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup"><?php echo $count_haki ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Total HaKi</span></h3>
                                        </li>


                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="column_chart_datalabel_haki" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-4">Haki Dosen</h4>
                                    <div class="float-end">
                                        <label for="hakiDosen"> Ascending &nbsp;</label>
                                        <input id="hakiDosen" type="checkbox" onchange="onHakiDosenToggle()">
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody id="tHakiDosen">
                                                <?php foreach ($nHakiEachDosen as $tp) : ?>
                                                    <tr>
                                                        <td style="max-width: 40%;">
                                                            <a href="/dosen/<?=$tp['kode_dosen']?>">
                                                                <strong class="font-size-15 mb-1 fw-normal text-black"><?= $tp['kode_dosen']; ?></strong>
                                                                <p class="text-muted font-size-13 mb-0"> <?=
                                                                    ((strlen($tp['nama_dosen']) <= 15)
                                                                    ? $tp['nama_dosen']
                                                                    : substr($tp['nama_dosen'], 0, 15) . "...")
                                                                    ?>
                                                                </p>
                                                            </a>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end">
                                                            <?= $tp['nHaki']; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('partials/right-sidebar') ?>

<?= $this->include('partials/vendor-scripts') ?>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>


<script src="assets/js/pages/dashboard.init.js"></script>
<!-- apexcharts init -->
<!-- <script src="assets/js/pages/apexcharts.init.js"></script> -->


<script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="assets/js/pages/chartjs.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>

<script type="text/javascript">
    function onPublikasiDosenToggle() {
        const node = document.getElementById("tPublikasiDosen");
        const oldNodeChildren = Array.from(node.childNodes);
        node.innerHTML = "";
        node.append(...(oldNodeChildren.reverse()));
    }

    function onPenelitianDosenToggle() {
        const node = document.getElementById("tPenelitianDosen");
        const oldNodeChildren = Array.from(node.childNodes);
        node.innerHTML = "";
        node.append(...(oldNodeChildren.reverse()));
    }
    function onAbdimasDosenToggle() {
        const node = document.getElementById("tAbdimasDosen");
        const oldNodeChildren = Array.from(node.childNodes);
        node.innerHTML = "";
        node.append(...(oldNodeChildren.reverse()));
    }
    function onHakiDosenToggle() {
        const node = document.getElementById("tHakiDosen");
        const oldNodeChildren = Array.from(node.childNodes);
        node.innerHTML = "";
        node.append(...(oldNodeChildren.reverse()));
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
                toolbar: { show: false, }
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
                formatter: val =>  val + "",
                offsetY: -20,
                style: { fontSize: '12px', colors: ["#304758"] }
            },
            series: [{
                name: 'Penelitian',
                data: [ <?php foreach ($order_by_tahun_Asc as $obt) {
                            echo '"' . $obt['jumlah_pen'] . '",';
                        } ?> ]
            }],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [
                    <?php foreach ($order_by_tahun_Asc as $obt) { echo '"' . $obt['thn'] . '",'; } ?>
                ],
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
                    formatter: val => val + "",
                }
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#column_chart_datalabel"),
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
                toolbar: { show: false, }
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
            series: [{
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
                name: 'Prosiding Internasional',
                data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                            echo '' . $cpub['jumlah_prosiding_internasional'] . ',';
                        } ?>]
            }, {
                name: 'Prosiding Nasional',
                data: [<?php foreach ($getOrderByTahunAllJenis as $cpub) {
                            echo '' . $cpub['jumlah_prosiding_nasional'] . ',';
                        } ?>]
            }, ],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [
                    <?php foreach ($getOrderByTahunAllJenis as $cpub) { echo '' . $cpub['tahun'] . ','; } ?> 
                ],
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
        new ApexCharts(
            document.querySelector("#column_chart"),
            options
        ).render();
    }

    // column chart with datalabels
    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel_abdimas");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, }
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
            series: [{
                name: 'Abdimas',
                data: [ <?php foreach ($order_by_tahun_desc as $obt) {
                            echo '"' . $obt['jumlah_abd'] . '",';
                        } ?> ]
            }],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [ <?php foreach ($order_by_tahun_desc as $obt) {
                                echo '"' . $obt['thn'] . '",';
                            } ?> ],
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
                    formatter: val => val + "",
                }
            },
        }

        new ApexCharts(
            document.querySelector("#column_chart_datalabel_abdimas"),
            options
        ).render();
    }

    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel_haki");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: { show: false, }
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
            series: [{
                name: 'Haki',
                data: [ <?php foreach ($order_by_tahun_Asc_haki as $obt) {
                            echo '"' . $obt['jumlah_haki'] . '",';
                        } ?> ]
            }],
            grid: { borderColor: '#f1f1f1', },
            xaxis: {
                categories: [ <?php foreach ($order_by_tahun_Asc_haki as $obt) { 
                                echo '"' . $obt['thn'] . '",'; } 
                            ?> ],
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
                    formatter: val => val + "",
                }
            },
        }

        new ApexCharts(
            document.querySelector("#column_chart_datalabel_haki"),
            options
        ).render();
    }

    makeSmallChart( document.getElementById("smallChart__publikasi"), "#5b73e8")
    makeSmallChart( document.getElementById("smallChart__penelitian"), "#20C997")
    makeSmallChart( document.getElementById("smallChart__abdimas"), "#f1b44c")
    makeSmallChart( document.getElementById("smallChart__haki"), "#f46a6a")
</script>