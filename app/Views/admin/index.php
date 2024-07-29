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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
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

                                <h4 class="card-title">Data Publikasi</h4>
                                <div>
                                    <a href="/admin/publikasi" class="btn btn-success waves-effect waves-light mb-3" role="button"><i class="mdi mdi-plus me-1"></i>Tambah Publikasi</a>
                                    <!-- <button href="/admin/publikasi" type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add customers</button> -->
                                </div>

                                <table id="datatable" data-ordering='false'  data-order='[[0, "desc"]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Judul Publikasi</th>
                                            <th>Jenis</th>
                                            <th>Jurnal/konferensi</th>
                                            <th>Action</th>
                                            <!-- <th>Akreditasi Jurnal</th> -->
                                            <!-- <th>Penulis</th>    -->
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1 ?>

                                        <?php foreach ($all_publikasi as $alp) : ?>
                                            <tr>
                                                <td><?= $alp['tahun']; ?></td>
                                                <td><?= $alp['judul_publikasi']; ?></td>
                                                <td><?= $alp['jenis']; ?></td>
                                                <td><?= $alp['nama_journal_conf']; ?></td>
                                                <td>
                                                    <ul class="d-flex list-inline mb-0"  style="gap: 12px;">
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('#')?>'"
                                                            >
                                                                <i class="uil uil-eye font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('admin/publikasi/update/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-pen font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-danger"
                                                                onclick="window.location = '<?=base_url('admin/publikasi/delete/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-trash-alt font-size-18"></i>
                                                            </button>
                                                        </li>

                                                    </ul>
                                                </td>


                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col"> </div>
                                    <div class="col-auto">
                                        <a href="/publikasi" class="btn btn-success waves-effect waves-light mb-3" role="button"></i>Lihat Selengkapnya</a>
                                        <!-- <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send float-end"></i></button> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data Penelitian</h4>
                                <!-- <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p> -->
                                <div>
                                    <a href="/admin/penelitian" class="btn btn-success waves-effect waves-light mb-3" role="button"><i class="mdi mdi-plus me-1"></i>Tambah Penelitian</a>
                                    <!-- <button href="/admin/publikasi" type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add customers</button> -->
                                </div>

                                <table id="datatable_1" data-ordering='false' data-order='[[0, "desc"]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Jenis</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Judul Penelitian</th>
                                            <th>Action</th>
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

                                                <td>
                                                    <ul class="d-flex list-inline mb-0" style="gap: 12px;">
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('#')?>'"
                                                            >
                                                                <i class="uil uil-eye font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('admin/penelitian/update/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-pen font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-danger"
                                                                onclick="window.location = '<?=base_url('admin/penelitian/delete/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-trash-alt font-size-18"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col"> </div>
                                    <div class="col-auto">
                                        <a href="/penelitian" class="btn btn-success waves-effect waves-light mb-3" role="button"></i>Lihat Selengkapnya</a>
                                        <!-- <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send float-end"></i></button> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data Abdimas</h4>
                                <div>
                                    <a href="/admin/abdimas" class="btn btn-success waves-effect waves-light mb-3" role="button"><i class="mdi mdi-plus me-1"></i>Tambah Abdimas</a>
                                    <!-- <button href="/admin/publikasi" type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add customers</button> -->
                                </div>


                                <table id="datatable_2" data-ordering='false' data-order='[[0, "desc"]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Jenis</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Judul</th>
                                            <!-- <th>Status</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php foreach ($all_abdimas as $alp) : ?>
                                            <tr>
                                                <td><?= $alp['tahun']; ?></td>
                                                <td><?= $alp['jenis']; ?></td>
                                                <td><?= $alp['nama_kegiatan']; ?></td>
                                                <td><?= $alp['judul']; ?></td>
                                                <!-- <td><?= $alp['status']; ?></td> -->
                                                <td>
                                                    <ul class="d-flex list-inline mb-0"  style="gap: 12px;">
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('#')?>'"
                                                            >
                                                                <i class="uil uil-eye font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('admin/abdimas/update/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-pen font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-danger"
                                                                onclick="window.location = '<?=base_url('admin/abdimas/delete/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-trash-alt font-size-18"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col"> </div>
                                    <div class="col-auto">
                                        <a href="/abdimas" class="btn btn-success waves-effect waves-light mb-3" role="button"></i>Lihat Selengkapnya</a>
                                        <!-- <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send float-end"></i></button> -->
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Data Haki</h4>
                                <!-- <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p> -->
                                <div>
                                    <a href="/admin/haki" class="btn btn-success waves-effect waves-light mb-3" role="button"><i class="mdi mdi-plus me-1"></i>Tambah Haki</a>
                                    <!-- <button href="/admin/publikasi" type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="mdi mdi-plus me-1"></i> Add customers</button> -->
                                </div>

                                <table id="datatable_3" data-ordering='false' data-ordering='false' data-order='[[0, "desc"]]' class="table table-bordered dt-responsive nowrap" data-page-length='5' style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Jenis</th>
                                            <!-- <th>Jenis Ciptaan</th> -->
                                            <th>Judul</th>

                                            <th>No Pendaftaran</th>
                                            <th>No Sertifikat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1 ?>

                                        <?php foreach ($all_haki as $alp) : ?>
                                            <tr>
                                                <td><?= $alp['tahun']; ?></td>
                                                <td><?= $alp['jenis']; ?></td>

                                                <td><?= $alp['judul']; ?></td>

                                                <td><?= $alp['no_pendaftaran']; ?></td>
                                                <td><?= $alp['no_sertifikat']; ?></td>
                                                <td>
                                                    <ul class="d-flex list-inline mb-0" style="gap: 12px;">
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('#')?>'"
                                                            >
                                                                <i class="uil uil-eye font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-primary"
                                                                onclick="window.location = '<?=base_url('admin/haki/update/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-pen font-size-18"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button 
                                                                class="p-0 border-0 bg-transparent text-danger"
                                                                onclick="window.location = '<?=base_url('admin/haki/delete/' . $alp['id'])?>'"
                                                            >
                                                                <i class="uil uil-trash-alt font-size-18"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col"> </div>
                                    <div class="col-auto">
                                        <a href="/haki" class="btn btn-success waves-effect waves-light mb-3" role="button"></i>Lihat Selengkapnya</a>
                                        <!-- <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send float-end"></i></button> -->
                                    </div>
                                </div>
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