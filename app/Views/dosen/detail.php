<?= $this->include('partials/main') ?>

<head>
    <?= $this->include('partials/head-css') ?>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Data Table CSS -->
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
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

                <div class="row mb-4">
                    <div class="col-xl-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown float-end">
                                        <a class="text-body dropdown-toggle font-size-18" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div>
                                        <img src="assets/images/users/avatar-4.jpg" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                    </div>
                                    <h5 class="mt-3 mb-1"><?= $dosen['nama_dosen']; ?></h5>
                                    <p class="text-muted"><?= $dosen['kode_dosen']; ?></p>
                                </div>

                                <hr class="my-4">

                                <div class="text-muted">
                                    <h5 class="font-size-16">Kelompok Keahlian :</h5>
                                    <p>Intelligence System</p>
                                    <div class="table-responsive mt-4">
                                        <div>
                                            <p class="mb-1">Nama :</p>
                                            <h5 class="font-size-16"><?= $dosen['nama_dosen']; ?></h5>
                                        </div>
                                        <!-- <div class="mt-4">
                                            <p class="mb-1">Mobile :</p>
                                            <h5 class="font-size-16">012-234-5678</h5>
                                        </div> -->
                                        <!-- <div class="mt-4">
                                            <p class="mb-1">Jumlah Publikasi :</p>
                                            <h5 class="font-size-16"></h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Jumlah Publikasi Penulis 1 :</p>
                                            <h5 class="font-size-16"></h5>
                                        </div> -->
                                        <hr class="my-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Publikasi Penulis 1</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_publikasi_1 ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Total Publikasi</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_publikasi ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Ketua Penelitian</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_ketua_peneliti ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2">Total Penelitian</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_penelitian ?></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Abdimas</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_ketua ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Haki</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_haki ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card mb-0">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#publikasi" role="tab">
                                        <i class="uil uil-user-circle font-size-20"></i>
                                        <span class="d-none d-sm-block">Publikasi</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#penelitian" role="tab">
                                        <i class="uil uil-clipboard-notes font-size-20"></i>
                                        <span class="d-none d-sm-block">Penelitian</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#abdimas" role="tab">
                                        <i class="uil uil-envelope-alt font-size-20"></i>
                                        <span class="d-none d-sm-block">Abdimas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#haki" role="tab">
                                        <i class="uil uil-envelope-alt font-size-20"></i>
                                        <span class="d-none d-sm-block">HaKi</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content p-4">
                                <div class="tab-pane active" id="publikasi" role="tabpanel">
                                    <div>
                                        <!-- <div>
                                            <h5 class="font-size-16 mb-4">Experience</h5>

                                            <ul class="activity-feed mb-0 ps-2">
                                                <li class="feed-item">
                                                    <div class="feed-item-list">
                                                        <p class="text-muted mb-1">2019 - 2020</p>
                                                        <h5 class="font-size-16">UI/UX Designer</h5>
                                                        <p>Abc Company</p>
                                                        <p class="text-muted">To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual</p>
                                                    </div>
                                                </li>
                                                <li class="feed-item">
                                                    <div class="feed-item-list">
                                                        <p class="text-muted mb-1">2017 - 2019</p>
                                                        <h5 class="font-size-16">Graphic Designer</h5>
                                                        <p>xyz Company</p>
                                                        <p class="text-muted">It will be as simple as occidental in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental </p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div> -->

                                        <div>
                                            <h5 class="font-size-16 mb-4">Publikasi</h5>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No</th>
                                                            <th scope="col">Judul</th>
                                                            <th scope="col">Tahun</th>
                                                            <th scope="col">Jenis</th>
                                                            <th scope="col" style="width: 120px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1 ?>
                                                        <?php foreach ($publikasi as $pb) : ?>
                                                            <tr>
                                                                <th scope="row"><?= $i++; ?></th>
                                                                <td><a href="#" class="text-reset "><?= $pb['judul_publikasi']; ?></a></td>
                                                                <td>
                                                                    <?= $pb['tahun']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $pb['link_artikel']; ?><!-- <span class="badge bg-primary-subtle font-size-12">Open</span> -->
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <a class="text-muted dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                            <i class="uil uil-ellipsis-v"></i>
                                                                        </a>

                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <a class="dropdown-item" href="#">Action</a>
                                                                            <a class="dropdown-item" href="#">Another action</a>
                                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="penelitian" role="tabpanel">
                                    <div>
                                        <h5 class="font-size-16 mb-3">Penelitian</h5>

                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Jenis</th>
                                                        <th scope="col" style="width: 120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($penelitian as $pn) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $i++; ?></th>
                                                            <td><a href="#" class="text-reset "><?= $pn['judul_penelitian']; ?></a></td>
                                                            <td>
                                                                <?= $pn['tahun']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $pn['status']; ?><!-- <span class="badge bg-primary-subtle font-size-12">Open</span> -->
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="uil uil-ellipsis-v"></i>
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="abdimas" role="tabpanel">
                                    <div>
                                        <h5 class="font-size-16 mb-3">Abdimas</h5>

                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Jenis</th>
                                                        <th scope="col" style="width: 120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($abdimas as $ab) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $i++; ?></th>
                                                            <td><a href="#" class="text-reset "><?= $ab['judul']; ?></a></td>
                                                            <td>
                                                                <?= $ab['tahun']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $ab['status']; ?><!-- <span class="badge bg-primary-subtle font-size-12">Open</span> -->
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="uil uil-ellipsis-v"></i>
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="haki" role="tabpanel">
                                    <div>
                                        <h5 class="font-size-16 mb-3">Haki</h5>

                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Jenis</th>
                                                        <th scope="col" style="width: 120px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($haki as $hk) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $i++; ?></th>
                                                            <td><a href="#" class="text-reset "><?= $hk['judul']; ?></a></td>
                                                            <td>
                                                                <?= $hk['tahun']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $hk['jenis']; ?><!-- <span class="badge bg-primary-subtle font-size-12">Open</span> -->
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                        <i class="uil uil-ellipsis-v"></i>
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item" href="#">Action</a>
                                                                        <a class="dropdown-item" href="#">Another action</a>
                                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                                    </div>
                                                                </div>
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
                <!-- end row -->

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

<!-- apexcharts -->
<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="/assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="/assets/js/app.js"></script>

</body>

</html>