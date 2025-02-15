<?= $this->include('partials/main') ?>
<head>
    <?= $this->include('partials/head-css') ?>
</head>

<?php // Initial PHP
    $tahunPenelitianTersedia = [];
    $dosenKetuaByTahun = [];
    $dosenKetuaByKK = [];
    $dosenByKK = [];
    foreach($dosen as $d) {
        $kkDosen = $d["KK"];
        $kodeDosen = $d["kode_dosen"];
        if(isset($dosenByKK[$kkDosen])) {
            array_push($dosenByKK[$kkDosen], $kodeDosen);
            $dosenKetuaByKK[$kkDosen][$kodeDosen] = 0;
        } else {
            $dosenKetuaByTahun[$kodeDosen] = [];
            $dosenByKK[$kkDosen] = [$kodeDosen];
            $dosenKetuaByKK[$kkDosen] = [
                $kodeDosen => 0
            ];
        }
    }

    $penelitianTypes = [];
    foreach($all_penelitian as $a) { // OPtimizable?
        $tahunPenelitian = $a["tahun"];
        $ketuaPeneliti = $a["ketua_peneliti"];
        $jenisPenelitian = strtoupper($a["jenis"]);
        if(!in_array($jenisPenelitian, $penelitianTypes)) {
            array_push($penelitianTypes, $jenisPenelitian);
        }

        if(strlen($ketuaPeneliti) > 0) {
            foreach($dosenByKK as $kk => $dList) {
                foreach($dList as $d) {
                    if($d == $ketuaPeneliti) {
                        if(isset($dosenKetuaByTahun[$ketuaPeneliti][$tahunPenelitian])) {
                            $dosenKetuaByTahun[$ketuaPeneliti][$tahunPenelitian] += 1;
                        } else {
                            $dosenKetuaByTahun[$ketuaPeneliti][$tahunPenelitian] = 1;
                        }

                        $dosenKetuaByKK[$kk][$ketuaPeneliti] += 1;
                    }
                }
            }
        }

        if(!in_array($tahunPenelitian, $tahunPenelitianTersedia)) {
            array_push($tahunPenelitianTersedia, $tahunPenelitian);
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
                <div class="row">
                    <h5>Total</h5>
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Ekster ?></span></h4>
                                    <p class="text-muted mb-0">Eksternal</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="orders-chart" data-colors='["--bs-success"]'> </div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Internal</p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="customers-chart" data-colors='["--bs-primary"]'> </div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Mand ?></span></h4>
                                    <p class="text-muted mb-0">Mandiri</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="growth-chart" data-colors='["--bs-warning"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Kerjasama_PT ?></span></h4>
                                    <p class="text-muted mb-0">Kerjasama PT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <!-- <div id="growth-chart" data-colors='["--bs-warning"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Hilir ?></span></h4>
                                    <p class="text-muted mb-0">Hilirisasi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5>Tahun <?php echo date("Y"); ?></h5>
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__eksternal" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Ekster ?></span></h4>
                                    <p class="text-muted mb-0">Eksternal</p>
                                </div>
                                <?php if ($peningkatan_Penelitian_Ekster >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_Penelitian_Ekster ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_Penelitian_Ekster ?> Penelitian</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__internal" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="orders-chart" data-colors='["--bs-success"]'> </div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Internal</p>
                                </div>
                                <?php if ($peningkatan_Penelitian_Inter >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_Penelitian_Inter ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_Penelitian_Inter ?> Penelitian</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__mandiri" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="customers-chart" data-colors='["--bs-primary"]'> </div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Mand ?></span></h4>
                                    <p class="text-muted mb-0">Mandiri</p>
                                </div>
                                <?php if ($peningkatan_Penelitian_Mand >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_Penelitian_Mand ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_Penelitian_Mand ?> Penelitian</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__kerjasamaPT" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="growth-chart" data-colors='["--bs-warning"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Kerjasama_PT ?></span></h4>
                                    <p class="text-muted mb-0">Kerjasama PT</p>
                                </div>
                                <?php if ($peningkatan_Penelitian_Kerjasama_PT >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_Penelitian_Kerjasama_PT ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_Penelitian_Kerjasama_PT ?> Penelitian</span>dari tahun sebelumnya
                                    </p>
                                <?php endif ?>

                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-xl">

                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="smallChart__hilirisasi" style="min-height: 40px; min-width: 70px;"></div>
                                    <!-- <div id="growth-chart" data-colors='["--bs-warning"]'></div> -->
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Hilir ?></span></h4>
                                    <p class="text-muted mb-0">Hilirisasi</p>
                                </div>
                                <?php if ($peningkatan_Penelitian_Hilir >= 0) : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i><?php echo $peningkatan_Penelitian_Hilir ?> Penelitian</span> dari tahun sebelumnya
                                    </p>
                                <?php else : ?>
                                    <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i><?php echo $peningkatan_Penelitian_Hilir ?> Penelitian</span>dari tahun sebelumnya
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
                                                <p id="chartPenelitianPerTahun__KK"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PENELITIAN_PER_TAHUN = {...FILTER_PENELITIAN_PER_TAHUN,  kk: ''}; onPenelitianPerTahunFilterUpdate(); "
                                            > Semua </button>
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PENELITIAN_PER_TAHUN = {...FILTER_PENELITIAN_PER_TAHUN, kk: '<?= $KK ?>'}; onPenelitianPerTahunFilterUpdate(); "
                                                >
                                                    <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Penelitian</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup"><?php echo $count_penelitian ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Total Penelitian</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartPenelitianPerTahun" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Total Penelitian</h4>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah Penelitian</th>
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
                                    </div> <!-- enbd table-responsive-->
                                </div> <!-- data-sidebar-->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end Col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-8 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="float-end">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">KK:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartPenelitianPerJenisTahunan__KK"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PENELITIAN_PER_JENIS_TAHUNAN = {...FILTER_PENELITIAN_PER_JENIS_TAHUNAN,  kk: ''}; onPenelitianPerJenisTahunanFilterUpdate(); "
                                            > Semua </button>
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PENELITIAN_PER_JENIS_TAHUNAN = {...FILTER_PENELITIAN_PER_JENIS_TAHUNAN, kk: '<?= $KK ?>'}; onPenelitianPerJenisTahunanFilterUpdate(); "
                                                >
                                                    <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Statistik Penelitian per Tahun</h4>

                                <div class="mt-1">
                                    <ul class="list-inline main-chart mb-0">
                                        <!-- <li class="list-inline-item chart-border-left me-0 border-0">
                                            <h3 class="text-primary"><span data-plugin="counterup">137</span><span class="text-muted d-inline-block font-size-15 ms-3">Total Publikasi</span></h3>
                                        </li> -->
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Ekster ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Eksternal</span>
                                            </h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Inter ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Internal</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Mand ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Mandiri</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Kerjasama_PT ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Kerjasama PT</span></h3>
                                        </li>
                                        <li class="list-inline-item chart-border-left me-0">
                                            <h3><span data-plugin="counterup"><?php echo $Penelitian_YearNow_Hilir ?></span><span class="text-muted d-inline-block font-size-15 ms-3">Hilirisasi</span></h3>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartPenelitianPerJenisTahunan" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title mb-4">Grafik Penelitian</h4>
                                <div style="flex: 1;" id="pie_chart" data-colors='["--bs-info", "--bs-success", "--bs-warning", "--bs-danger" , "--bs-purple"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div> <!-- end Col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Data Penelitian </h4>
                                <div id="bar_chart" data-colors='["--bs-success"]' class="apex-charts" style="max-height: 339px" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Penelitian</h4>

                                <div data-simplebar style="max-height: 339px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody>
                                                <?php foreach ($top_penelitian as $tp) : ?>
                                                    <tr>
                                                        <td>
                                                            <a href="/dosen/<?= $tp['kode_dosen']?>">
                                                                <strong class="font-size-15 mb-1 fw-normal text-black"><?= $tp['kode_dosen']; ?></strong>
                                                                <p class="text-muted font-size-13 mb-0"> <?= $tp['nama_dosen']; ?></p>
                                                            </a>
                                                        </td>
                                                        <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= $tp['nPenelitian']; ?></td>
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
                                        <label for="penelitianDosen__recentKetuaOnly"> Hanya ketua 4 tahun terakhir&nbsp;</label>
                                        <input id="penelitianPerDosen__recentKetuaOnly" type="checkbox" onchange="toggleRecentKetuaOnlyFilter()">
                                    </div>
                                    <div class="dropdown me-2" id="penelitianPerDosen__yearDropdown">
                                        <a class="dropdown-toggle text-reset d-flex" href="#" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Tahun:&nbsp; </span> 
                                            <div class="text-muted d-flex"> 
                                                <p id="chartPenelitianPerDosen__tahun"> Semua </p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PENELITIAN_PER_DOSEN = {...FILTER_PENELITIAN_PER_DOSEN,  tahun: 'Semua'}; onPenelitianPerDosenFilterUpdate(); "
                                            > Semua </button>
                                            <button 
                                                class="dropdown-item" 
                                                onclick="FILTER_PENELITIAN_PER_DOSEN = {...FILTER_PENELITIAN_PER_DOSEN,  tahun: 'Recent'}; onPenelitianPerDosenFilterUpdate(); "
                                            > (4 Tahun Terakhir) </button>
                                            <?php foreach($tahunPenelitianTersedia as $tahun): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PENELITIAN_PER_DOSEN = {...FILTER_PENELITIAN_PER_DOSEN, tahun: '<?= $tahun ?>'}; onPenelitianPerDosenFilterUpdate(); "
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
                                                <p id="chartPenelitianPerDosen__KK"> KK <?= array_keys($dosenByKK)[0]?></p>
                                                <i class="mdi mdi-chevron-down ms-1"> </i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                            <?php foreach($dosenByKK as $KK => $_): ?>
                                                <button 
                                                    class="dropdown-item" 
                                                    onclick="FILTER_PENELITIAN_PER_DOSEN = {...FILTER_PENELITIAN_PER_DOSEN, kk: '<?= $KK ?>'}; onPenelitianPerDosenFilterUpdate(); "
                                                >
                                                    KK <?= $KK ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="card-title mb-4">Statistik Penelitian</h4>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_datalabel_1" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="chartPenelitianPerDosen" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="dosenKetuaPenelitian" class="float-end" style="display: none">
                                    <label> Hanya Ketua Penelitian &nbsp;</label>
                                    <input id="dosenKetuaPenelitianToggle" type="checkbox" onchange="onPenelitianDosenFilterUpdate();"/>
                                </div>
                                <div data-simplebar style="max-height: 339px;">
                                    <h4 id="chartPenelitian__title" class="card-title mb-4">Statistik Penelitian Dosen Pertahun</h4>
                                    <p id="chartPenelitian__desc"> Klik pada salah satu dosen untuk melihat statistik penelitian dosen tersebut</p>
                                </div>
                                <div id="chartPenelitianDosen"> </div>
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
                                <h4 class="card-title">Data Penelitian</h4>
                                <table id="datatable" data-order='[[ 0, "desc" ]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Judul Penelitian</th>
                                            <th>Jenis</th>
                                            <th>Status</th>
                                            <th>Peneliti</th>
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
<!-- <script src="assets/js/pages/apexcharts.init.js"></script> -->

<script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
<script src="assets/js/pages/chartjs.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>

<?= view('penelitian/jsScript', [
    "dosenByKK" => $dosenByKK,
    "data_tahunan" => $data_tahunan,
    "defaultFilterKK" => "'" . array_keys($dosenByKK)[0] . "'",
    "all_penelitian" => $all_penelitian,

    "order_by_tahun_Asc" => $order_by_tahun_Asc,
    "countPublikasi" => $count_publikasi,
    "getOrderByTahunInternal" => $getOrderByTahunInternal,
    "getOrderByTahunEksternal" => $getOrderByTahunEksternal,
    "getOrderByTahunMandiri" => $getOrderByTahunMandiri,
    "getOrderByTahunKerjasamaPT" => $getOrderByTahunKerjasamaPT,
    "getOrderByTahunHilirisasi" => $getOrderByTahunHilirisasi,
    "top_penelitian_all" => $top_penelitian_all,

    "availablePenelitianYear"  => $tahunPenelitianTersedia,
    "dosenKetuaByYear"  => $dosenKetuaByTahun,
    "annualPenelitianByType" => $annualPenelitianByType,
    "annualPenelitianByTypeAndKK" => $annualPenelitianByTypeAndKK,
    "penelitianTypes" => $penelitianTypes
]) ?>