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



<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('partials/menu') ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <?= $validation->listErrors(); ?>
                <form action="/admin/publikasi_save">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Input Data Publikasi</h4>
                                    <p class="card-title-desc">Masukan data <code>publikasi</code> ke dalam <code>form</code> berikut</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Judul Publikasi</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" id="Judul-Publikasi" name="judul">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-md-2 col-form-label">Tahun</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number" id="example-number-input" name="tahun">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Jenis Publikasi</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="jenis">
                                                <option>Jurnal Internasional</option>
                                                <option>Jurnal Nasional</option>
                                                <option>Prosiding Internasional</option>
                                                <option>Prosiding Nasional</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="card-title">Data Penulis</h4> -->
                                    <p class="card-title-desc">Masukan data <code>penulis</code> ke dalam <code>form</code> berikut.</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Penulis 1</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="kode dosen" id="Judul-Publikasi" name="penulis_1">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Penulis 2</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="masukan jika terdapat penulis 2" id="Judul-Publikasi" name="penulis_2">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Penulis 3</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="masukan jika terdapat penulis 3" id="Judul-Publikasi" name="penulis_3">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Penulis 4</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="masukan jika terdapat penulis 4" id="Judul-Publikasi" name="penulis_4">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Penulis 5</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="masukan jika terdapat penulis 5" id="Judul-Publikasi" name="penulis_5">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Penulis 6</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="masukan jika terdapat penulis 6" id="Judul-Publikasi" name="penulis_6">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Semua Penulis</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="masukan semua penulis" id="Judul-Publikasi" name="semua_penulis">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Layout -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <h4 class="card-title">Input Data Publikasi</h4> -->
                                    <p class="card-title-desc">Masukan data <code>publikasi</code> ke dalam <code>form</code> berikut</p>

                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Institusi Mitra</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="institusi mitra" id="Judul-Publikasi" name="mitra">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Nama Jurnal/konferensi </label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" placeholder="jurnal/konferensi" id="Judul-Publikasi" name="jurnal_konferensi">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Akreditasi</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="akreditasi">
                                                <option>Q1</option>
                                                <option>Q2</option>
                                                <option>Q3</option>
                                                <option>Q4</option>
                                                <option>S1</option>
                                                <option>S2</option>
                                                <option>S3</option>
                                                <option>S4</option>
                                                <option>S5</option>
                                                <option>S6</option>
                                                <option>Scopus</option>
                                                <option>not accredited yet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-url-input" class="col-md-2 col-form-label">URL Artikel</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="url" placeholder="Link Artikel" id="example-url-input" name="link">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Luaran riset/abdimas</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="luaran">
                                                <option>Riset</option>
                                                <option>Abdimas</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <!-- <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Inline forms layout</h5> -->


                                    </div>



                                </div>

                            </div>

                        </div> <!-- end col -->

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <p class="card-title-desc">Submit hasil <code>isian</code> data anda dengan klik <code>tombol</code> berikut</p>
                                    <!-- <form> -->
                                    <div class="hstack gap-3">
                                        <!-- <input class="form-control me-auto" type="text" placeholder="Add your item here..." aria-label="Add your item here..."> -->
                                        <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
                                        <div class="vr"></div>
                                        <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <!-- Start Form Sizing -->

                    <!-- end row -->
                </form>

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

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>
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