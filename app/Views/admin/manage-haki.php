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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Input Data Haki</h4>
                                <p class="card-title-desc">Masukan data <code>Haki</code> ke dalam <code>form</code> berikut</p>

                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Judul Haki</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Judul" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-number-input" class="col-md-2 col-form-label">Tahun</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="number" placeholder="2024" id="example-number-input">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-md-2 col-form-label">Jenis Haki</label>
                                    <div class="col-md-10">
                                        <select class="form-select">
                                            <option>PATEN</option>
                                            <option>HAK CIPTA</option>
                                            <option>MEREK</option>
                                            <option>KARYA/BUKU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Jenis Ciptaan</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Jenis Ciptaan" id="Judul-Publikasi">
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <label for="exampleDataList" class="col-md-2 col-form-label">Datalists</label>
                                    <div class="col-md-10">
                                        <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                        <datalist id="datalistOptions">
                                            <option value="San Francisco">
                                            <option value="New York">
                                            <option value="Seattle">
                                            <option value="Los Angeles">
                                            <option value="Chicago">
                                        </datalist>
                                    </div>
                                </div> -->
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
                                <p class="card-title-desc">Masukan data <code>Anggota</code> ke dalam <code>form</code> berikut.</p>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Ketua</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 1</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 2</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 3</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 4</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 5</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 6</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 7</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 8</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Anggota 9</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Kode Dosen" id="Judul-Publikasi">
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
                                    <label for="example-text-input" class="col-md-2 col-form-label">Abstrak</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="abstrak" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">No Pendaftaran </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="No Pendaftaran" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">No Sertifikat </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="No Sertifikat" id="Judul-Publikasi">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Catatan </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" placeholder="Catatan" id="Judul-Publikasi">
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

                                <form>
                                    <div class="hstack gap-3">
                                        <!-- <input class="form-control me-auto" type="text" placeholder="Add your item here..." aria-label="Add your item here..."> -->
                                        <button type="button" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
                                        <div class="vr"></div>
                                        <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <!-- Start Form Sizing -->

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