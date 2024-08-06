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
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif ?>
                <div class="row mb-4">
                    <div class="col-xl-12">
                        <div class="card mb-3 p-4">
                            <h2> Log Aktivitas </h2>
                            <p> 
                                Halaman ini menampilkan sejumlah aktivitas terakhir untuk <code>publikasi</code>, 
                                <code> penelitian</code>, <code>abdimas</code>, dan <code>haki</code>. Untuk mengunduh 
                                keseluruhan log aktivitas tersebut, silakan akses tombol berikut:
                            </p>
                            <div>
                                <button 
                                    type="button"
                                    class="btn btn-outline-primary" 
                                >Log Publikasi</button>
                                <button 
                                    type="button"
                                    class="btn btn-outline-primary" 
                                >Log Penelitian</button>
                                <button 
                                    type="button"
                                    class="btn btn-outline-primary" 
                                >Log Abdimas</button>
                                <button 
                                    type="button"
                                    class="btn btn-outline-primary" 
                                >Log Haki</button>
                            </div>
                        </div>
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
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Kode Dosen</th>
                                                    <th scope="col" class="text-center">Pengguna</th>
                                                    <th scope="col" class="text-center">Waktu</th>
                                                    <th scope="col" class="text-center">Keterangan</th>
                                                    <th scope="col" class="text-center" style="width: 4ch;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($logPublikasi as $l): ?>
                                                    <tr style="margin: auto">
                                                        <td class="text-center align-middle"> 
                                                            <strong> <?= is_null($l["kode_dosen"])? "~": $l["kode_dosen"] ?> </strong>
                                                        </td>
                                                        <td> 
                                                            <p class="m-0 p-0">
                                                                <i class="uil-user-square"></i>
                                                                <?= is_null($l["username"])? "~": $l["username"] ?>
                                                            </p>
                                                            <p class="m-0 p-0">
                                                                <i class="uil-envelope"></i>
                                                                <?= is_null($l["email"])? "~": $l["email"] ?>
                                                            </p>
                                                        </td>
                                                        <td class="text-center align-middle"> <?= $l["date"] ?> </td>
                                                        <td class="align-middle"> 
                                                            <?php
                                                                $msg = "";
                                                                switch($l["action"]) {
                                                                    case "C": $msg = "Menambah"; break;
                                                                    case "U": $msg = "Merubah"; break;
                                                                    case "D": $msg = "Menghapus"; break;
                                                                }
                                                                echo "$msg publikasi dengan id <strong>" . $l["publikasi_id"] . "</strong>";
                                                            ?> 
                                                        </td>
                                                        <td class="text-center align-middle"> 
                                                            <a style="width: 20px; display: block; margin: auto;"
                                                                href="<?=base_url("admin/log/publikasi/view/" . $l['id'])?>"
                                                                class="uil uil-eye font-size-18"> </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="penelitian" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Kode Dosen</th>
                                                    <th scope="col" class="text-center">Pengguna</th>
                                                    <th scope="col" class="text-center">Waktu</th>
                                                    <th scope="col" class="text-center">Keterangan</th>
                                                    <th scope="col" class="text-center" style="width: 4ch;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($logPenelitian as $l): ?>
                                                    <tr style="margin: auto">
                                                        <td class="text-center align-middle"> 
                                                            <strong> <?= is_null($l["kode_dosen"])? "~": $l["kode_dosen"] ?> </strong>
                                                        </td>
                                                        <td> 
                                                            <p class="m-0 p-0">
                                                                <i class="uil-user-square"></i>
                                                                <?= is_null($l["username"])? "~": $l["username"] ?>
                                                            </p>
                                                            <p class="m-0 p-0">
                                                                <i class="uil-envelope"></i>
                                                                <?= is_null($l["email"])? "~": $l["email"] ?>
                                                            </p>
                                                        </td>
                                                        <td class="text-center align-middle"> <?= $l["date"] ?> </td>
                                                        <td class="align-middle"> 
                                                            <?php
                                                                $msg = "";
                                                                switch($l["action"]) {
                                                                    case "C": $msg = "Menambah"; break;
                                                                    case "U": $msg = "Merubah"; break;
                                                                    case "D": $msg = "Menghapus"; break;
                                                                }
                                                                echo "$msg penelitian dengan id <strong>" . $l["penelitian_id"] . "</strong>";
                                                            ?> 
                                                        </td>
                                                        <td class="text-center align-middle"> 
                                                            <a style="width: 20px; display: block; margin: auto;"
                                                                href="<?=base_url("admin/log/penelitian/view/" . $l['id'])?>"
                                                                class="uil uil-eye font-size-18"> </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="abdimas" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Kode Dosen</th>
                                                    <th scope="col" class="text-center">Pengguna</th>
                                                    <th scope="col" class="text-center">Waktu</th>
                                                    <th scope="col" class="text-center">Keterangan</th>
                                                    <th scope="col" class="text-center" style="width: 4ch;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($logAbdimas as $l): ?>
                                                    <tr style="margin: auto">
                                                        <td class="text-center align-middle"> 
                                                            <strong> <?= is_null($l["kode_dosen"])? "~": $l["kode_dosen"] ?> </strong>
                                                        </td>
                                                        <td> 
                                                            <p class="m-0 p-0">
                                                                <i class="uil-user-square"></i>
                                                                <?= is_null($l["username"])? "~": $l["username"] ?>
                                                            </p>
                                                            <p class="m-0 p-0">
                                                                <i class="uil-envelope"></i>
                                                                <?= is_null($l["email"])? "~": $l["email"] ?>
                                                            </p>
                                                        </td>
                                                        <td class="text-center align-middle"> <?= $l["date"] ?> </td>
                                                        <td class="align-middle"> 
                                                            <?php
                                                                $msg = "";
                                                                switch($l["action"]) {
                                                                    case "C": $msg = "Menambah"; break;
                                                                    case "U": $msg = "Merubah"; break;
                                                                    case "D": $msg = "Menghapus"; break;
                                                                }
                                                                echo "$msg abdimas dengan id <strong>" . $l["abdimas_id"] . "</strong>";
                                                            ?> 
                                                        </td>
                                                        <td class="text-center align-middle"> 
                                                            <a style="width: 20px; display: block; margin: auto;"
                                                                href="<?=base_url("admin/log/abdimas/view/" . $l['id'])?>"
                                                                class="uil uil-eye font-size-18"> </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="haki" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Kode Dosen</th>
                                                    <th scope="col" class="text-center">Pengguna</th>
                                                    <th scope="col" class="text-center">Waktu</th>
                                                    <th scope="col" class="text-center">Keterangan</th>
                                                    <th scope="col" class="text-center" style="width: 4ch;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($logHaki as $l): ?>
                                                    <tr style="margin: auto">
                                                        <td class="text-center align-middle"> 
                                                            <strong> <?= is_null($l["kode_dosen"])? "~": $l["kode_dosen"] ?> </strong>
                                                        </td>
                                                        <td> 
                                                            <p class="m-0 p-0">
                                                                <i class="uil-user-square"></i>
                                                                <?= is_null($l["username"])? "~": $l["username"] ?>
                                                            </p>
                                                            <p class="m-0 p-0">
                                                                <i class="uil-envelope"></i>
                                                                <?= is_null($l["email"])? "~": $l["email"] ?>
                                                            </p>
                                                        </td>
                                                        <td class="text-center align-middle"> <?= $l["date"] ?> </td>
                                                        <td class="align-middle"> 
                                                            <?php
                                                                $msg = "";
                                                                switch($l["action"]) {
                                                                    case "C": $msg = "Menambah"; break;
                                                                    case "U": $msg = "Merubah"; break;
                                                                    case "D": $msg = "Menghapus"; break;
                                                                }
                                                                echo "$msg Haki dengan id <strong>" . $l["haki_id"] . "</strong>";
                                                            ?> 
                                                        </td>
                                                        <td class="text-center align-middle"> 
                                                            <a style="width: 20px; display: block; margin: auto;"
                                                                href="<?=base_url("admin/log/haki/view/" . $l['id'])?>"
                                                                class="uil uil-eye font-size-18"> </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
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