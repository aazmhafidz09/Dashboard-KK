<?= $this->include('partials/main') ?>

<head>
    <?= $this->include('partials/head-css') ?>
</head>

<?php // Initial PHP
    $tahunHakiTersedia = [];
    foreach($all_haki as $a) { // OPtimizable?
        $tahunHaki = $a["tahun"];
        $isExist = false;
        $idx = 0;
        while(!$isExist && $idx < count($tahunHakiTersedia)) {
            $isExist = $tahunHakiTersedia[$idx] == $tahunHaki;
            $idx += 1;
        }

        if(!$isExist) array_push($tahunHakiTersedia, $tahunHaki);
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
                <h5>Total</h5>
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Haki_Cipta ?></span></h4>
                                    <p class="text-muted mb-0">Hak Cipta</p>
                                </div>
                                <!-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>7 Haki</span> dari tahun sebelumnya </p> -->
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Haki_Paten ?></span></h4>
                                    <p class="text-muted mb-0">Paten</p>
                                </div>
                                <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>-4 Haki</span> dari tahun sebelumnya </p> -->
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Haki_Merek ?></span></h4>
                                    <p class="text-muted mb-0">Merek</p>
                                </div>
                                <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>-2 Haki</span> dari tahun sebelumnya </p> -->
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Haki_Buku ?></span></h4>
                                    <p class="text-muted mb-0">Buku</p>
                                </div>
                                <!-- <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>10.51%</span> since last week </p> -->
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <h5>Tahun <?php echo date("Y"); ?></h5>
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $HakiYearNow_Cipta ?></span></h4>
                                    <p class="text-muted mb-0">Hak Cipta</p>
                                </div>
                                <?php if ($peningkatan_haki_cipta >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_haki_cipta ?> Hak Cipta</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_haki_cipta ?> Hak Cipta</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $HakiYearNow_Paten ?></span></h4>
                                    <p class="text-muted mb-0">Paten</p>
                                </div>
                                <?php if ($peningkatan_haki_paten >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_haki_paten ?> Paten</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_haki_paten ?> Paten</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $hakiYearNow_Merek ?></span></h4>
                                    <p class="text-muted mb-0">Merek</p>
                                </div>
                                <?php if ($peningkatan_haki_merek >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_haki_merek ?> Merek</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_haki_merek ?> Merek</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $hakiYearNow_Buku ?></span></h4>
                                    <p class="text-muted mb-0">Buku</p>
                                </div>
                                <?php if ($peningkatan_haki_buku >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_haki_buku ?> Buku</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_haki_buku ?> Buku</span>dari tahun sebelumnya
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
                                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <a class="dropdown-item" href="#">Monthly</a>
                                            <a class="dropdown-item" href="#">Yearly</a>
                                            <a class="dropdown-item" href="#">Weekly</a>
                                        </div>
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
                                    <div id="column_chart_datalabel" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item" href="#">Monthly</a>
                                            <a class="dropdown-item" href="#">Yearly</a>
                                            <a class="dropdown-item" href="#">Weekly</a>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="card-title mb-4">Total Haki</h4>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah Haki</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($order_by_tahun as $obt) : ?>
                                                    <tr>
                                                        <th scope="row"><?= $i++; ?></th>
                                                        <td><?= $obt['thn']; ?></td>
                                                        <td><?= $obt['jumlah_haki']; ?></td>
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
                                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <a class="dropdown-item" href="#">Monthly</a>
                                            <a class="dropdown-item" href="#">Yearly</a>
                                            <a class="dropdown-item" href="#">Weekly</a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik HaKi</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <!-- <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup">137</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Haki</span></h3>
                                        </li> -->
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $HakiYearNow_Cipta ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Hak Cipta</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $HakiYearNow_Paten ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Paten</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $hakiYearNow_Merek ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Merek</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $hakiYearNow_Buku ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Buku</span></h3>
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
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Diagram Haki</h4>

                                    <div id="pie_chart" data-colors='["--bs-success", "--bs-primary", "--bs-warning" ,"--bs-info", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item" href="#">Monthly</a>
                                            <a class="dropdown-item" href="#">Yearly</a>
                                            <a class="dropdown-item" href="#">Weekly</a>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="card-title mb-4">Top Selling Products</h4>


                                <div class="row align-items-center g-0 mt-3">
                                    <div class="col-sm-3">
                                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> Haki </p>
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
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted">All Members<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="#">Locations</a>
                                            <a class="dropdown-item" href="#">Revenue</a>
                                            <a class="dropdown-item" href="#">Join Date</a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Haki Terbanyak</h4>

                                <div data-simplebar style="max-height: 339px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody>
                                                <?php foreach ($top_haki as $tp) : ?>
                                                    <tr>
                                                        <!-- <td style="width: 20px;"><img src="assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td> -->
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal"><?= $tp['kode_dosen']; ?></h6>
                                                            <p class="text-muted font-size-13 mb-0"> <?= $tp['nama_dosen']; ?></p>
                                                        </td>
                                                        <!-- <td><span class="badge bg-danger-subtle text-danger font-size-12"></span></td> -->
                                                        <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= $tp['jumlah_haki']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                </div> <!-- data-sidebar-->
                            </div><!-- end card-body-->
                        </div> <!-- end card-->
                    </div><!-- end col -->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <!-- <span class="text-muted">Recent<i class="mdi mdi-chevron-down ms-1"></i></span> -->
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item" href="#">Recent</a>
                                            <a class="dropdown-item" href="#">By Users</a>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="card-title mb-4">Data Haki</h4>

                                <ol class="activity-feed mb-0 ps-2" data-simplebar style="height: 339px;">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Haki</th>
                                                    <th>Jumlah</th>
                                                    <!-- <th>Username</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($count_haki_all as $cpub) :  ?>
                                                    <tr>
                                                        <th scope="row"><?= $i++; ?></th>
                                                        <td><?= $cpub['jenis_haki']; ?></td>
                                                        <td><?= $cpub['jumlah_haki']; ?></td>
                                                        <!-- <td>@mdo</td> -->
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Data Haki </h4>
                                <div id="bar_chart" style="max-height: 339px" data-colors='["--bs-success"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end d-flex">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Tahun:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartStatistikHaki_tahun"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="CHART_STATISTIK_HAKI_FILTER = {...CHART_STATISTIK_HAKI_FILTER,  tahun: 'Semua'}; makeChartHaki(); "
                                            > Semua </button>
                                            <?php foreach($tahunHakiTersedia as $tahun): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="CHART_STATISTIK_HAKI_FILTER = {...CHART_STATISTIK_HAKI_FILTER, tahun: '<?= $tahun ?>'}; makeChartHaki(); "
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
                                                <p id="chartStatistikHaki_KK"> KK <?= array_keys($dosenByKK)[0]?></p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="CHART_STATISTIK_HAKI_FILTER = {...CHART_STATISTIK_HAKI_FILTER, kk: '<?= $KK ?>'}; makeChartHaki(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="card-title mb-4">Statistik HaKi</h4>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartStatistikHaki" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data Haki</h4>
                                <!-- <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p> -->

                                <table id="datatable" data-order='[[ 0, "desc" ]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Jenis</th>
                                            <!-- <th>Jenis Ciptaan</th> -->
                                            <th>Judul</th>
                                            <th>Pengusul 1</th>
                                            <th>Pengusul 2</th>
                                            <th>Pengusul 3</th>
                                            <th>Pengusul 4</th>
                                            <th>No Pendaftaran</th>
                                            <th>No Sertifikat</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1 ?>

                                        <?php foreach ($all_haki as $alp) : ?>
                                            <tr>
                                                <td><?= $alp['tahun']; ?></td>
                                                <td><?= $alp['jenis']; ?></td>

                                                <td><?= $alp['judul']; ?></td>
                                                <td><?= $alp['ketua']; ?></td>
                                                <td><?= $alp['anggota_1']; ?></td>
                                                <td><?= $alp['anggota_2']; ?></td>
                                                <td><?= $alp['anggota_3']; ?></td>
                                                <td><?= $alp['no_pendaftaran']; ?></td>
                                                <td><?= $alp['no_sertifikat']; ?></td>
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
<!-- <script src="assets/js/pages/apexcharts.init.js"></script> -->

<script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="assets/js/pages/chartjs.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>

<?= view("haki/jsScript", [
    "defaultFilterKK" => "'" . array_keys($dosenByKK)[0] . "'",
    "dosenByKK" => $dosenByKK,
    "data_tahunan" => $data_tahunan,
    "order_by_tahun_Asc" => $order_by_tahun_Asc,
    "hakiCipta" => $Haki_Cipta,
    "hakiPaten" => $Haki_Paten,
    "hakiMerek" => $Haki_Merek,
    "hakiBuku" => $Haki_Buku,
    "getOrderByTahunAllJenis" => $getOrderByTahunAllJenis,
    "top_haki_all" => $top_haki_all,
    "count_haki_all" => $count_haki_all,
])?>