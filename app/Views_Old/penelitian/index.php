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
                <h5>Total</h5>
                <div class="row">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Ekster ?></span></h4>
                                    <p class="text-muted mb-0">Eksternal</p>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Inter ?></span></h4>
                                    <p class="text-muted mb-0">Internal</p>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Mand ?></span></h4>
                                    <p class="text-muted mb-0">Mandiri</p>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Kerjasama_PT ?></span></h4>
                                    <p class="text-muted mb-0">Kerjasama PT</p>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $Penelitian_Hilir ?></span></h4>
                                    <p class="text-muted mb-0">Hilirisasi</p>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <h5>Tahun <?php echo date("Y"); ?></h5>
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
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
                                    <div id="orders-chart" data-colors='["--bs-success"]'> </div>
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
                                    <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
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
                                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
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
                                    <div id="growth-chart" data-colors='["--bs-warning"]'></div>
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

                                <h4 class="card-title mb-4">Total Penelitian</h4>
                                <div data-simplebar style="max-height: 408px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah Penelitian</th>
                                                    <!-- <th>Username</th> -->
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
                                    <div id="column_chart" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-xl-4">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Grafik Penelitian</h4>

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

                                <h4 class="card-title mb-4">Penelitian</h4>


                                <div class="row align-items-center g-0 mt-3">
                                    <div class="col-sm-3">
                                        <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> Internal</p>
                                    </div>

                                    <div class="col-sm-9">
                                        <div class="progress mt-1" style="height: 6px;">
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
                                <h4 class="card-title mb-4">Penelitian Terbanyak</h4>

                                <div data-simplebar style="max-height: 339px;">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-centered table-nowrap">
                                            <tbody>
                                                <?php foreach ($top_penelitian as $tp) : ?>
                                                    <tr>
                                                        <!-- <td style="width: 20px;"><img src="assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td> -->
                                                        <td>
                                                            <h6 class="font-size-15 mb-1 fw-normal"><?= $tp['kode_dosen']; ?></h6>
                                                            <p class="text-muted font-size-13 mb-0"> <?= $tp['nama_dosen']; ?></p>
                                                        </td>
                                                        <!-- <td><span class="badge bg-danger-subtle text-danger font-size-12"><?= $tp['jumlah_penelitian']; ?></span></td> -->
                                                        <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i><?= $tp['jumlah_penelitian']; ?></td>
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

                                <h4 class="card-title mb-4">Data Penelitian</h4>

                                <ol class="activity-feed mb-0 ps-2" data-simplebar style="height: 339px;">

                                    <div class="table-responsive">
                                        <table class="table mb-0">

                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Penelitian</th>
                                                    <th>Jumlah</th>
                                                    <!-- <th>Username</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($count_publikasi as $cpub) :  ?>
                                                    <tr>
                                                        <th scope="row"><?= $i++; ?></th>
                                                        <td><?= $cpub['jenis_pen']; ?></td>
                                                        <td><?= $cpub['jumlah_pen']; ?></td>
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
                                <h4 class="card-title mb-4">Data Penelitian </h4>
                                <div id="bar_chart" data-colors='["--bs-success"]' class="apex-charts" style="max-height: 339px" dir="ltr"></div>
                            </div>
                        </div><!--end card-->
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Statistik Penelitian</h4>
                                <div class="mt-3">
                                    <!-- <div id="sales-analytics-chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    <!-- <div id="column_chart_1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div> -->
                                    <div id="column_chart_datalabel_1" data-colors='["--bs-primary"]' class="apex-charts" dir="ltr"></div>
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
                                    <h4 class="card-title mb-4">Statistik Penelitian Dosen Pertahun</h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Kode Dosen</th>
                                                    <th>2000</th>
                                                    <th>2001</th>
                                                    <th>2002</th>
                                                    <th>2003</th>
                                                    <th>2004</th>
                                                    <th>2005</th>
                                                    <th>2006</th>
                                                    <th>2007</th>
                                                    <th>2008</th>
                                                    <th>2009</th>
                                                    <th>2010</th>
                                                    <th>2011</th>
                                                    <th>2012</th>
                                                    <th>2013</th>
                                                    <th>2014</th>
                                                    <th>2015</th>
                                                    <th>2016</th>
                                                    <th>2017</th>
                                                    <th>2018</th>
                                                    <th>2019</th>
                                                    <th>2020</th>
                                                    <th>2021</th>
                                                    <th>2022</th>
                                                    <th>2023</th>
                                                    <th>2024</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $data_tahunan ?>
                                                
                                                <?php $i = 1 ?>
                                                <?php foreach ($data_tahunan as $dt) : ?>
                                                    <tr>

                                                        <td><a href="javascript: void(0);" class="text-body fw-bold"><?= $dt['kode_dosen']; ?></a> </td>
                                                        <td><?= $dt['THN_2000']; ?></td>
                                                        <td>
                                                            <?= $dt['THN_2001']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2002']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2003']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2004']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2005']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2006']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2007']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2008']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2009']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2010']; ?>
                                                        </td>

                                                        <td>
                                                            <?= $dt['THN_2011']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2012']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2013']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2014']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2015']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2016']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2017']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2018']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2019']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2020']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2021']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2022']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2023']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $dt['THN_2024']; ?>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                                <!-- <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p> -->

                                <table id="datatable" data-order='[[ 0, "desc" ]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Jenis</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Judul Penelitian</th>
                                            <th>Ketua</th>
                                            <th>anggota 1</th>
                                            <th>anggota 2</th>
                                            <th>anggota 3</th>
                                            <th>anggota 4</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1 ?>

                                        <?php foreach ($all_penelitian as $alp) : ?>
                                            <tr>
                                                <td><?= $alp['tahun']; ?></td>
                                                <td><?= $alp['jenis']; ?></td>
                                                <td><?= $alp['nama_kegiatan']; ?></td>
                                                <td><?= $alp['judul_penelitian']; ?></td>
                                                <td><?= $alp['ketua_peneliti']; ?></td>
                                                <td><?= $alp['anggota_peneliti_1']; ?></td>
                                                <td><?= $alp['anggota_peneliti_2']; ?></td>
                                                <td><?= $alp['anggota_peneliti_3']; ?></td>
                                                <td><?= $alp['anggota_peneliti_4']; ?></td>
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

<script type="text/javascript">
    // column chart with datalabels
    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
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
                formatter: function(val) {
                    return val + "";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'penelitian',
                data: [
                    <?php foreach ($order_by_tahun_Asc as $obt) {
                        echo '"' . $obt['jumlah_pen'] . '",';
                    }

                    ?>
                    // 8, 14, 15, 15, 17, 22, 38, 39, 56, 42
                ]
            }],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {

                categories: [<?php foreach ($order_by_tahun_Asc as $obt) {
                                    echo '"' . $obt['thn'] . '",';
                                }
                                ?> '2024'],
                position: 'down',
                labels: {
                    offsetY: 0,

                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: true
                },
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
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
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
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return val + " Penelitian";
                    }
                }

            },

        }

        var chart = new ApexCharts(
            document.querySelector("#column_chart_datalabel"),
            options
        );

        chart.render();

    }


    // pie chart
    var PiechartPieColors = getChartColorsArray("pie_chart");
    if (PiechartPieColors) {
        var options = {
            chart: {
                height: 320,
                type: 'pie',
            },
            series: [<?php foreach ($count_publikasi as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>],
            labels: [<?php foreach ($count_publikasi as $cpub) {
                            echo '"' . $cpub['jenis_pen'] . '",';
                        }

                        ?>],

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
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }]

        }

        var chart = new ApexCharts(
            document.querySelector("#pie_chart"),
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
                toolbar: {
                    show: false,
                }
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
                formatter: function(val) {
                    return val + "";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'Eksternal',
                data: [<?php foreach ($getOrderByTahunEksternal as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Internal',
                data: [<?php foreach ($getOrderByTahunInternal as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Mandiri',
                data: [<?php foreach ($getOrderByTahunMandiri as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Kerja Sama PT',
                data: [<?php foreach ($getOrderByTahunKerjasamaPT as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, {
                name: 'Hilirisasi',
                data: [<?php foreach ($getOrderByTahunHilirisasi as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }, ],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {

                categories: [<?php foreach ($getOrderByTahunEksternal as $cpub) {
                                    echo '' . $cpub['thn'] . ',';
                                }

                                ?> 2024],
                position: 'down',
                labels: {
                    offsetY: 0,

                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: true
                },
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
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
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
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return val + " Penelitian";
                    }
                }

            },

        }
        var chart = new ApexCharts(
            document.querySelector("#column_chart"),
            options
        );

        chart.render();

    }

    // Bar chart
    var BarchartBarColors = getChartColorsArray("bar_chart");
    if (BarchartBarColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                data: [<?php foreach ($count_publikasi as $cpub) {
                            echo '' . $cpub['jumlah_pen'] . ',';
                        }

                        ?>]
            }],
            colors: BarchartBarColors,
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {
                categories: ['Eksternal', 'Hilirisasi', 'Internal', 'Kemitraan', 'Kerja Sama PT', 'Mandiri'],
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#bar_chart"),
            options
        );

        chart.render();

    }

    // column chart with datalabels
    var BarchartColumnChartColors = getChartColorsArray("column_chart_datalabel_1");
    if (BarchartColumnChartColors) {
        var options = {
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false,
                }
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
                formatter: function(val) {
                    return val + "";
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'Penelitian',
                data: [<?php foreach ($top_penelitian_all as $cpub) {
                            echo '"' . $cpub['jumlah_penelitian'] . '",';
                        }

                        ?>]
            }],
            grid: {
                borderColor: '#f1f1f1',
            },
            xaxis: {

                categories: [<?php foreach ($top_penelitian_all as $cpub) {
                                    echo '"' . $cpub['kode_dosen'] . '",';
                                }

                                ?>],
                position: 'down',
                labels: {
                    offsetY: 0,

                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: true
                },
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
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
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
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                        return val + " Penelitian";
                    }
                }

            },

        }

        var chart = new ApexCharts(
            document.querySelector("#column_chart_datalabel_1"),
            options
        );

        chart.render();

    }
</script>