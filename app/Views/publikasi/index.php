<?= $this->include('partials/main') ?>

<head>
    <?= $this->include('partials/head-css') ?>
</head>

<?php // Initial PHP
    $dosenPenulisPertamaPerTahun = [];
    $tahunPublikasiTersedia = [];
    $dosenByKK = [];
    foreach($dosen as $d) {
        $kkDosen = $d["KK"]; // By KK
        $kodeDosen = $d["kode_dosen"];
        if(isset($dosenByKK[$kkDosen])) {
            array_push($dosenByKK[$kkDosen], $kodeDosen);
        } else {
            $dosenByKK[$kkDosen] = [$kodeDosen];
            $dosenPenulisPertamaPerTahun[$kodeDosen] = [];
        }
    }

    foreach($all_publikasi as $a) { // OPtimizable?
        $penulisPertama = $a["penulis_1"];
        $tahunPublikasi = $a["tahun"];

        if(!isset($dosenPenulisPertamaPerTahun[$penulisPertama][$tahunPublikasi])) {
            $dosenPenulisPertamaPerTahun[$penulisPertama][$tahunPublikasi] = 0;
        }

        if(in_array(strtolower($a['jenis']), ["jurnal internasional", "jurnal nasional"])) {
            $dosenPenulisPertamaPerTahun[$penulisPertama][$tahunPublikasi]++;
        }

        if(!in_array($tahunPublikasi, $tahunPublikasiTersedia)) {
            array_push($tahunPublikasiTersedia, $tahunPublikasi);
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
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Publikasi_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Jurnal Internasional</p>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Publikasi_Nas ?></span></h4>
                                    <p class="text-muted mb-0">Jurnal Nasional</p>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Publikasi_Pros ?></span></h4>
                                    <p class="text-muted mb-0">Prosiding Internasional</p>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-xl-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Publikasi_Pros_Nas ?></span></h4>
                                    <p class="text-muted mb-0">Prosiding Nasional</p>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <h5>Tahun <?php echo date("Y"); ?></h5>
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div> -->
                                    <div id="smallChart__jurnalInternasional" style="min-height: 40px; min-width: 70px;"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $PublikasiYearNow_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Jurnal Internasional</p>
                                </div>
                                <?php if ($peningkatan_publikasi_inter >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_publikasi_inter ?> Publikasi</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_publikasi_inter ?> Publikasi</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__jurnalNasional" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="orders-chart" data-colors='["--bs-success"]'> </div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $PublikasiYearNow_Nas ?></span></h4>
                                    <p class="text-muted mb-0">Jurnal Nasional</p>
                                </div>
                                <?php if ($peningkatan_publikasi_nas >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_publikasi_nas ?> Publikasi</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_publikasi_nas ?> Publikasi</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>


                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__prosidingInternasional" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="customers-chart" data-colors='["--bs-primary"]'> </div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $PublikasiYearNow_Pros ?></span></h4>
                                    <p class="text-muted mb-0">Prosiding Internasional</p>
                                </div>
                                <?php if ($peningkatan_publikasi_pros >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_publikasi_pros ?> Publikasi</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_publikasi_pros ?> Publikasi</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__prosidingNasional" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="growth-chart" data-colors='["--bs-warning"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $PublikasiYearNow_Pros_Nas ?></span></h4>
                                    <p class="text-muted mb-0">Prosiding Nasional</p>
                                </div>
                                <?php if ($peningkatan_publikasi_pros_nas >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_publikasi_pros_nas ?> Publikasi</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_publikasi_pros_nas ?> Publikasi</span>dari tahun sebelumnya
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
                                                <p id="chartPublikasiPerTahun__KK"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PUBLIKASI_PER_TAHUN = {...FILTER_PUBLIKASI_PER_TAHUN, kk: ''}; onPublikasiPerTahunFilterUpdate(); "
                                            > 
                                                Semua
                                            </button>
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PUBLIKASI_PER_TAHUN = {...FILTER_PUBLIKASI_PER_TAHUN, kk: '<?= $KK ?>'}; onPublikasiPerTahunFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                </div>
                                <h4 class="card-title mb-4">Statistik Publikasi</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup"><?php echo $count_publikasi ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Total Publikasi</span></h3>
                                        </li>

                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartPublikasiPerTahun" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Total Publikasi</h4>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah Publikasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($order_by_tahun as $obt) : ?>
                                                    <tr>
                                                        <th scope="row"><?= $i++; ?></th>
                                                        <td><?= $obt['thn']; ?></td>
                                                        <td><?= $obt['jumlah_pen']; ?></td>
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
                    <div class="col-xl-8 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">KK:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartPublikasiPerJenisTahunan__KK"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PUBLIKASI_PER_JENIS_TAHUNAN = {...FILTER_PUBLIKASI_PER_JENIS_TAHUNAN, kk: ''}; onPublikasiPerJenisTahunanFilterUpdate(); "
                                            >
                                                Semua
                                            </button>
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PUBLIKASI_PER_JENIS_TAHUNAN = {...FILTER_PUBLIKASI_PER_JENIS_TAHUNAN, kk: '<?= $KK ?>'}; onPublikasiPerJenisTahunanFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                </div>
                                <h4 class="card-title mb-4">Statistik Publikasi</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <!-- <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup">137</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Publikasi</span></h3>
                                        </li> -->
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $PublikasiYearNow_Inter ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Jurnal Internasional</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $PublikasiYearNow_Nas ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Jurnal Nasional</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $PublikasiYearNow_Pros ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Prosiding Internasional</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $PublikasiYearNow_Pros_Nas ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Prosiding Nasional</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartPublikasiPerJenisTahunan" data-colors='[ "--bs-info", "--bs-success", "--bs-warning", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Diagram Publikasi</h4>

                                <div id="pie_chart" data-colors='["--bs-primary", "--bs-success", "--bs-warning", "--bs-danger"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end Col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"> Peringkat Publikasi</h4>
                                <div id="bar_chart" data-colors='["--bs-success"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Publikasi</h4>

                                <div data-simplebar style="max-height: 339px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody>
                                                <?php foreach ($top_publikasi as $tp) : ?>
                                                    <tr>
                                                        <!-- <td style="width: 20px;"><img src="assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td> -->
                                                        <td>
                                                            <a href="/dosen/<?= $tp['kode_dosen'] ?>">
                                                                <strong class="font-size-15 mb-1 fw-normal text-black"><?= $tp['kode_dosen']; ?></strong>
                                                                <p class="text-muted font-size-13 mb-0"><?= $tp['nama_dosen']; ?></p>
                                                            </a>
                                                        </td>
                                                        <!-- <td><span class="badge bg-danger-subtle text-danger font-size-12">#</span></td>g -->
                                                        <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= $tp['nPublikasi']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div> <!-- enbd table-responsive-->
                                </div> <!-- data-sidebar-->
                            </div><!-- end card-body-->
                        </div> <!-- end card-->
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end d-flex">
                                    <div class="me-2">
                                        <label for="penelitianDosen__recentKetuaOnly"> Hanya penulis pertama jurnal 4 tahun terakhir&nbsp;</label>
                                        <input id="penelitianPerDosen__recentKetuaOnly" type="checkbox" onchange="toggleRecentPenulisPertamaOnlyFilter()">
                                    </div>
                                    <div class="dropdown me-2" id="publikasiPerDosen__yearDropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Tahun:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartPublikasiPerDosen__tahun"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PUBLIKASI_PER_DOSEN = {...FILTER_PUBLIKASI_PER_DOSEN,  tahun: 'Semua'}; onPublikasiPerDosenFilterUpdate(); "
                                            > Semua </button>
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PUBLIKASI_PER_DOSEN = {...FILTER_PUBLIKASI_PER_DOSEN,  tahun: 'Recent'}; onPublikasiPerDosenFilterUpdate(); "
                                            > (4 Tahun Terakhir) </button>
                                            <?php foreach($tahunPublikasiTersedia as $tahun): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PUBLIKASI_PER_DOSEN = {...FILTER_PUBLIKASI_PER_DOSEN, tahun: '<?= $tahun ?>'}; onPublikasiPerDosenFilterUpdate(); "
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
                                                <p id="chartPublikasiPerDosen__KK"> KK <?= array_keys($dosenByKK)[0]?></p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PUBLIKASI_PER_DOSEN = {...FILTER_PUBLIKASI_PER_DOSEN, kk: '<?= $KK ?>'}; onPublikasiPerDosenFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Publikasi</h4>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_datalabel_1" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartPublikasiPerDosen" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="dosenKetuaPublikasi" class="float-end" style="display: none">
                                    <label> Hanya Penulis Pertama Jurnal &nbsp;</label>
                                    <input id="dosenKetuaPublikasiToggle" type="checkbox" onchange="onPublikasiDosenFilterUpdate();"/>
                                </div>
                                <div data-simplebar style="max-height: 339px;">
                                    <h4 class="card-title mb-4" id="chartPublikasi__title">Statistik Publikasi</h4>
                                    <p id="chartPublikasi__desc"> Klik pada salah satu dosen untuk melihat statistik publikasi dosen tersebut</p>
                                </div>
                                <div id="chartPublikasiDosen"> </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Publikasi</h4>
                                <table id="datatable" data-order='[[ 0, "desc" ]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Judul Publikasi</th>
                                            <th>Jenis</th>
                                            <th>Jurnal/konferensi</th>
                                            <th>Peringkat Jurnal</th>
                                            <th>Penulis</th>
                                            <th></th>
                                        </tr>
                                    </thead>
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
<!-- <script src="assets/js/pages/script_publikasi.php"></script> -->

<script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="assets/js/pages/chartjs.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>

<?= view("publikasi/jsScript", [
    "defaultFilterKK" => "'" . array_keys($dosenByKK)[0] . "'",
    "dosenByKK" => $dosenByKK,
    "data_tahunan" => $data_tahunan,
    "annualPublikasiByTypeAndKK" => $annualPublikasiByTypeAndKK,
    "order_by_tahun_Asc" => $order_by_tahun_Asc,
    "getOrderByTahunAllJenis" => $getOrderByTahunAllJenis,
    "count_publikasi_all" => $count_publikasi_all,
    "akreditasi_jurnal" => $akreditasi_jurnal,
    "dosenPenulisPertamaPerTahun" => $dosenPenulisPertamaPerTahun,
    "availablePublikasiYear" => $tahunPublikasiTersedia
])?>