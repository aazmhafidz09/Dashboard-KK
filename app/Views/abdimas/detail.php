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
                                        <h3>Keterangan Abdimas</h3>
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
                                                    "Judul" => $abdimas["judul"],
                                                    "Tahun" => $abdimas["tahun"],
                                                    "Ketua" => $abdimas["ketua"],
                                                    "Anggota" => (implode( ", ", array_filter([ 
                                                                $abdimas['anggota_1'],
                                                                $abdimas['anggota_2'],
                                                                $abdimas['anggota_3'],
                                                                $abdimas['anggota_4'],
                                                                $abdimas['anggota_5'],
                                                                $abdimas['anggota_6'],
                                                                $abdimas['anggota_7'],
                                                                $abdimas['anggota_8'],
                                                            ], function($v) { return strlen($v) > 0; }))),
                                                    "Nama Kegiatan" => $abdimas["nama_kegiatan"],
                                                    "Status" => $abdimas["status"],
                                                    "Jenis" => $abdimas["jenis"],
                                                    "Lab Riset" => $abdimas["lab_riset"],
                                                    "Tanggal Pengesahan" => $abdimas["tgl_pengesahan"],
                                                    "Mitra" => $abdimas["mitra"],
                                                    "Alamat Mitra" => $abdimas["alamat_mitra"],
                                                    "Permasalahan Masyarakat" => $abdimas["permasalahan_masy"],
                                                    "Solusi" => $abdimas["solusi"],
                                                    "Luaran" => $abdimas["luaran"],
                                                    "Kesesuaian Roadmap" => $abdimas["kesesuaian_roadmap"],
                                                    "Catatan" => $abdimas["catatan"],
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