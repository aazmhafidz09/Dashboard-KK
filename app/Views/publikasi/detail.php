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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <h3>Keterangan Publikasi</h3>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="table-responsive mb-4">
                                    <table id="example" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 16ch;"> </th>
                                                <th scope="col"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sections = [
                                                    "Judul" => $publikasi["judul_publikasi"],
                                                    "Tahun" => $publikasi["tahun"],
                                                    "Semua Penulis" => $publikasi["penulis_all"],
                                                    "Penulis" => (implode( ", ", array_filter([ 
                                                                $publikasi['penulis_1'],
                                                                $publikasi['penulis_2'],
                                                                $publikasi['penulis_3'],
                                                                $publikasi['penulis_4'],
                                                                $publikasi['penulis_5'],
                                                                $publikasi['penulis_6'],
                                                                $publikasi['penulis_7'],
                                                                $publikasi['penulis_8'],
                                                                $publikasi['penulis_9'],
                                                                $publikasi['penulis_10'],
                                                                $publikasi['penulis_11'], 
                                                            ], function($v) { return strlen($v) > 0; }))),
                                                    "Jurnal" => $publikasi["nama_journal_conf"],
                                                    "Akreditasi Jurnal" => $publikasi["akreditasi_journal_conf"],
                                                    "Jenis" => $publikasi["jenis"],
                                                    "Lab Riset" => $publikasi["lab_riset"],
                                                    "Mitra" => $publikasi["institusi_mitra"],
                                                ];
                                            ?>

                                            <?php foreach($sections as $sName => $sValue): ?>
                                                <tr>
                                                    <td><b><?= $sName ?></b></td>
                                                    <td><?= $sValue ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <?php if(strlen($publikasi["link_artikel"]) > 0): ?>
                                            <button class="btn btn-primary">
                                                <a class="text-white" href="<?=$publikasi["link_artikel"]?>"> Lihat publikasi</a>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary" disabled>
                                                <a class="text-white" href="#"> Tidak tersedia secara daring </a>
                                            </button>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- End Page-content -->


        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<?= $this->include('partials/right-sidebar') ?>

<?= $this->include('partials/vendor-scripts') ?>

<!-- App js -->
<script src="assets/js/app.js"></script>





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

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>