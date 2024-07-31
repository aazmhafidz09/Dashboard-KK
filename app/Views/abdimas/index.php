<?= $this->include('partials/main') ?>
<head>
    <?= $this->include('partials/head-css') ?>
</head>
<?= $this->include('partials/body') ?>

<?php // Initial PHP
    $tahunAbdimasTersedia = [];
    foreach($all_abdimas as $a) { // OPtimizable?
        $tahunAbdimas = $a["tahun"];
        $isExist = false;
        $idx = 0;
        while(!$isExist && $idx < count($tahunAbdimasTersedia)) {
            $isExist = $tahunAbdimasTersedia[$idx] == $tahunAbdimas;
            $idx += 1;
        }

        if(!$isExist) array_push($tahunAbdimasTersedia, $tahunAbdimas);
    }

    $dosenByKK = [];
    foreach($dosen as $d) {
        $kkDosen = $d["KK"]; // By KK
        $kodeDosen = $d["kode_dosen"];
        if(isset($dosenByKK[$kkDosen])) {
            array_push($dosenByKK[$kkDosen], $kodeDosen);
        } else {
            $dosenByKK[$kkDosen] = [$kodeDosen];
        }
    }
?>

<!-- Begin page -->
<div id="layout-wrapper">
    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- <h5>Total</h5> -->
                <div class="row">
                    <!-- <div class="col-md-6 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Abdimas_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Internal</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Abdimas_Ekster ?></span></h4>
                                    <p class="text-muted mb-0">Eksternal</p>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <h5>Tahun <?php echo date("Y"); ?></h5>
                    <div class="col-md-6 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Abdimas_YearNow_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Internal</p>
                                </div>
                                <?php if ($getPeningkatanAbdimasInter >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0">
                                        <span class="text-success me-1">
                                            <i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $getPeningkatanAbdimasInter ?> Abdimas
                                        </span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0">
                                        <span class="text-danger me-1">
                                            <i class="mdi mdi-arrow-down-bold me-1"></i> <?php echo $getPeningkatanAbdimasInter ?> Abdimas
                                        </span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Abdimas_YearNow_Ekster ?></span></h4>
                                    <p class="text-muted mb-0">Eksternal</p>
                                </div>
                                <?php if ($getPeningkatanAbdimasEkste >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $getPeningkatanAbdimasEkste ?> Abdimas</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $getPeningkatanAbdimasEkste ?> Abdimas</span>dari tahun sebelumnya
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
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">KK:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartAbdimasPerTahun__KK"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_ABDIMAS_PER_TAHUN = {...FILTER_ABDIMAS_PER_TAHUN, kk: ''}; onAbdimasPerTahunFilterUpdate(); "
                                            > 
                                                Semua
                                            </button>
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_ABDIMAS_PER_TAHUN = {...FILTER_ABDIMAS_PER_TAHUN, kk: '<?= $KK ?>'}; onAbdimasPerTahunFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
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
                                    <div id="chartAbdimasTahunan" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Total Abdimas</h4>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah Abdimas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($order_by_tahun as $obt) : ?>
                                                    <tr>
                                                        <th scope="row"><?= $i++; ?></th>
                                                        <td><?= $obt['thn']; ?></td>
                                                        <td><?= $obt['jumlah_abd']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                </div> <!-- data-sidebar-->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end Col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">KK:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartAbdimasPerJenisTahunan__KK"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_ABDIMAS_PER_JENIS_TAHUNAN = {...FILTER_ABDIMAS_PER_JENIS_TAHUNAN, kk: ''}; onAbdimasPerJenisTahunanFilterUpdate(); "
                                            > 
                                                Semua
                                            </button>
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_ABDIMAS_PER_JENIS_TAHUNAN = {...FILTER_ABDIMAS_PER_JENIS_TAHUNAN, kk: '<?= $KK ?>'}; onAbdimasPerJenisTahunanFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Abdimas</h4>
                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <!-- <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup">137</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Publikasi</span></h3>
                                        </li> -->
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Abdimas_YearNow_Inter ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Internal</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Abdimas_YearNow_Ekster ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Eksternal</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartAbdimasPerJenisTahunan" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Diagram Abdimas</h4>

                                    <div id="pie_chart" data-colors='["--bs-success", "--bs-primary", "--bs-warning" ,"--bs-info", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Total Abdimas</h4>
                                <div class="row align-items-center g-0 mt-3">
                                    <div class="col-sm-3">
                                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> Abdimas </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="progress mt-1" style="height: 8px;">
                                            <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 52%" aria-valuenow="52" aria-valuemin="0" aria-valuemax="52">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end Col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end d-flex">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Tahun:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartAbdimasPerDosen__tahun"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_ABDIMAS_PER_DOSEN = {...FILTER_ABDIMAS_PER_DOSEN,  tahun: 'Semua'}; onAbdimasPerDosenFilterUpdate(); "
                                            > Semua </button>
                                            <?php foreach($tahunAbdimasTersedia as $tahun): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_ABDIMAS_PER_DOSEN = {...FILTER_ABDIMAS_PER_DOSEN, tahun: '<?= $tahun ?>'}; onAbdimasPerDosenFilterUpdate(); "
                                                >
                                                    <?= $tahun ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">KK:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartAbdimasPerDosen__KK"> KK <?= array_keys($dosenByKK)[0]?></p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_ABDIMAS_PER_DOSEN = {...FILTER_ABDIMAS_PER_DOSEN, kk: '<?= $KK ?>'}; onAbdimasPerDosenFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="card-title mb-4">Statistik Abdimas</h4>
                                <div class="mt-3">
                                    <!-- <div id="column_chart_datalabel_1" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartAbdimasPerDosen" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div data-simplebar style="max-height: 339px;">
                                    <h4 class="card-title mb-4" id="chartAbdimas__title">Statistik Abdimas</h4>
                                    <p id="chartAbdimas__desc"> Klik pada salah satu dosen untuk melihat statistik abdimas dosen tersebut</p>
                                </div>
                                <div id="chartAbdimasDosen"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Abdimas</h4>
                                <table id="datatable" data-order='[[ 0, "desc" ]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Jenis</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Anggota</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($all_abdimas as $alp) : ?>
                                            <tr>
                                                <td><?= $alp['tahun']; ?></td>
                                                <td><?= $alp['jenis']; ?></td>
                                                <td><?= $alp['nama_kegiatan']; ?></td>
                                                <td><?= $alp['judul']; ?></td>
                                                <td><?= $alp['status']; ?></td>
                                                <td> <?= 
                                                    implode( ", ", 
                                                        array_filter([ 
                                                            $alp['ketua'], $alp['anggota_1'],
                                                            $alp['anggota_2'], $alp['anggota_3'],
                                                            $alp['anggota_4'], $alp['anggota_5'],
                                                            $alp['anggota_6'], $alp['anggota_7'],
                                                            $alp['anggota_8']
                                                            ], function($v) { return strlen($v) > 0; }
                                                        )); 
                                                ?> </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('partials/right-sidebar') ?>
<?= $this->include('partials/vendor-scripts') ?>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets/js/pages/datatables.init.js"></script>
<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>


<script src="assets/js/pages/dashboard.init.js"></script>
<script src="assets/js/pages/ecommerce-datatables.init.js"></script>
<!-- apexcharts init -->
<!-- <script src="assets/js/pages/apexcharts.init.js"></script>
> --
<script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="assets/js/pages/chartjs.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
</body>
</html>

<!-- Pass data needed by script here! -->
<?= view('abdimas/jsScript', [
    "defaultFilterKK" => "'" . array_keys($dosenByKK)[0] . "'",
    "tahun_abdimas_tersedia" => $tahunAbdimasTersedia,
    "dosenByKK" => $dosenByKK,
    "data_tahunan" => $data_tahunan,
    "annualAbdimasByTypeAndKK" => $annualDataByTypeAndKK,
    "order_by_tahun_desc" => $order_by_tahun_desc
]) ?>