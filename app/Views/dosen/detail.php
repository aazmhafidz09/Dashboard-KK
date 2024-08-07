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
                                    <p> <?= $dosen["KK"] ?></p>
                                    <div class="mt-4">
                                        <div>
                                            <h5 class="mb-1 font-size-16">Nama :</h5>
                                            <p class=""><?= $dosen['nama_dosen']; ?></p>
                                        </div>
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
                                                    <p class="text-muted mb-2"># Publikasi</p>
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
                                                    <p class="text-muted mb-2"> # Penelitian</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_penelitian ?></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <p class="text-muted mb-2"> Abdimas</p>
                                                    <h3 class="font-size-16 mb-0"><?php echo $jumlah_abdimas ?></h3>
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
                                        <i class="uil uil-clipboard-notes font-size-20"></i>
                                        <span class="d-none d-sm-block">Publikasi</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#penelitian" role="tab">
                                        <i class="uil uil-microscope font-size-20"></i>
                                        <span class="d-none d-sm-block">Penelitian</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#abdimas" role="tab">
                                        <i class="uil uil-users-alt font-size-20"></i>
                                        <span class="d-none d-sm-block">Abdimas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#haki" role="tab">
                                        <i class="uil uil-dropbox font-size-20"></i>
                                        <span class="d-none d-sm-block">HaKi</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content p-4">
                                <div class="tab-pane active" id="publikasi" role="tabpanel">
                                    <div>
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No</th>
                                                            <th scope="col">Judul</th>
                                                            <th scope="col">Tahun</th>
                                                            <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1 ?>
                                                        <?php foreach ($publikasi as $pb) : ?>
                                                            <tr>
                                                                <td scope="row"><?= $i++; ?></td>
                                                                <td>
                                                                    <p class="text-reset " > <?= (
                                                                        (strlen($pb['judul_publikasi']) <= 50)
                                                                        ? $pb['judul_publikasi']
                                                                        : substr($pb['judul_publikasi'], 0, 50) . "..."
                                                                    ); ?> </p>
                                                                </td>
                                                                <td> <?= $pb['tahun']; ?> </td>
                                                                <td> 
                                                                    <a 
                                                                        style="width: 20px; display: block; margin: auto;"
                                                                        href="<?=base_url("/publikasi/view/" . $pb['id'])?>"
                                                                        class="uil uil-eye font-size-18" >
                                                                    </a>
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
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($penelitian as $pn) : ?>
                                                        <tr>
                                                            <th scope="row"><?= $i++; ?></th>
                                                            <td>
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($pn['judul_penelitian']) <= 40)
                                                                    ? $pn['judul_penelitian']
                                                                    : substr($pn['judul_penelitian'], 0, 40) . "..."
                                                                ); ?> </p>
                                                            </td>
                                                            <td> <?= $pn['tahun']; ?> </td>
                                                            <td> <?= $pn['status']; ?> </td>
                                                            <td> 
                                                                <a 
                                                                    style="width: 20px; display: block; margin: auto;"
                                                                    href="<?=base_url("/penelitian/view/" . $pn['id'])?>"
                                                                    class="uil uil-eye font-size-18">
                                                                </a>
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
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Mitra</th>
                                                        <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($abdimas as $ab) : ?>
                                                        <tr>
                                                            <td scope="row"><?= $i++; ?></td>
                                                            <td>
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($ab['judul']) <= 40)
                                                                    ? $ab['judul']
                                                                    : substr($ab['judul'], 0, 40) . "..."
                                                                ); ?> </p>
                                                            <td> <?= $ab['tahun']; ?> </td>
                                                            <td> <?= $ab['status']; ?> </td>
                                                            <td> 
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($ab['mitra']) <= 20)
                                                                    ? $ab['mitra']
                                                                    : substr($ab['mitra'], 0, 20) . "..."
                                                                ); ?> </p>
                                                            </td>
                                                            <td> 
                                                                <a 
                                                                    style="width: 20px; display: block; margin: auto;"
                                                                    href="<?=base_url("/abdimas/view/" . $ab['id'])?>"
                                                                    class="uil uil-eye font-size-18">
                                                                </a>
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
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Judul</th>
                                                        <th scope="col">Tahun</th>
                                                        <th scope="col">Jenis</th>
                                                        <th scope="col" style="width: 6ch; text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1 ?>
                                                    <?php foreach ($haki as $hk) : ?>
                                                        <tr>
                                                            <td scope="row"><?= $i++; ?></td>
                                                            <td>
                                                                <p class="text-reset "> <?= (
                                                                    (strlen($hk['judul']) <= 40)
                                                                    ? $hk['judul']
                                                                    : substr($hk['judul'], 0, 40) . "..."
                                                                ); ?> </p>
                                                            </td>
                                                            <td> <?= $hk['tahun']; ?> </td>
                                                            <td> <?= $hk['jenis']; ?> </td>
                                                            <td> 
                                                                <a 
                                                                    style="width: 20px; display: block; margin: auto;"
                                                                    href="<?=base_url("/haki/view/" . $hk['id'])?>"
                                                                    class="uil uil-eye font-size-18">
                                                                </a>
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
        </div>

        <?= $this->include('partials/footer') ?>
    </div>
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