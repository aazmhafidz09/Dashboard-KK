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
                                        <h3>Keterangan Penelitian</h3>
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
                                                    "Judul" => $penelitian["judul_penelitian"],
                                                    "Tahun" => $penelitian["tahun"],
                                                    "Ketua" => $penelitian["ketua_peneliti"],
                                                    "Penulis" => (implode( ", ", array_filter([ 
                                                                $penelitian['anggota_peneliti_1'],
                                                                $penelitian['anggota_peneliti_2'],
                                                                $penelitian['anggota_peneliti_3'],
                                                                $penelitian['anggota_peneliti_4'],
                                                                $penelitian['anggota_peneliti_5'],
                                                                $penelitian['anggota_peneliti_6'],
                                                                $penelitian['anggota_peneliti_7'],
                                                                $penelitian['anggota_peneliti_8'],
                                                                $penelitian['anggota_peneliti_9'],
                                                                $penelitian['anggota_peneliti_10'],
                                                            ], function($v) { return strlen($v) > 0; }))),
                                                    "Jenis" => $penelitian["jenis"],
                                                    "Status" => $penelitian["status"],
                                                    "Nama Kegiatan" => $penelitian["nama_kegiatan"],
                                                    "Lab Riset" => $penelitian["lab_riset"],
                                                    "Mitra" => $penelitian["mitra"],
                                                    "Kesesuaian Roadmap" => $penelitian["kesesuaian_roadmap"],
                                                    "Luaran" => $penelitian["luaran"],
                                                    "Rekomendasi" => $penelitian["catatan_rekomendasi"],
                                                    "Mata Kuliah Relevan" => $penelitian["mk_relevan"],
                                                    "Tanggal Pengesahan" => $penelitian["tgl_pengesahan"],
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