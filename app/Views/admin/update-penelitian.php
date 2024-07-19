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
                <form action="/admin/handle_penelitian_edit/<?=esc($oldPenelitian["id"])?>" method="post">
                    <?= csrf_field(); ?> 
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update Data Penelitian</h4>
                                    <p class="card-title-desc">Masukan data <code>penelitian</code> ke dalam <code>form</code> berikut</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Judul Penelitian</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Judul Penelitian" 
                                                id="Judul-Publikasi" 
                                                name="judul"
                                                value="<?= esc($oldPenelitian["judul_penelitian"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Nama Kegiatan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Judul Penelitian" 
                                                id="Judul-Publikasi" 
                                                name="nama_kegiatan"
                                                value="<?= esc($oldPenelitian["nama_kegiatan"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-md-2 col-form-label">Tahun</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="number" 
                                                placeholder="Tahun" 
                                                id="example-number-input" 
                                                name="tahun"
                                                value="<?= esc($oldPenelitian["tahun"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Jenis Penelitian</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="jenis">
                                                <option <?= esc($oldPenelitian["jenis"] == "Internal"? "selected": "") ?> >
                                                    Internal
                                                </option>
                                                <option <?= esc($oldPenelitian["jenis"] == "Eksternal"? "selected": "") ?> >
                                                    Eksternal
                                                </option>
                                                <option <?= esc($oldPenelitian["jenis"] == "Mandiri"? "selected": "") ?> >
                                                    Mandiri
                                                </option>
                                                <option <?= esc($oldPenelitian["jenis"] == "Kerjasama Perguruan Tinggi"? "selected": "") ?> >
                                                    Kerjasama Perguruan Tinggi
                                                </option>
                                                <option <?= esc($oldPenelitian["jenis"] == "Kemitraan"? "selected": "") ?> >
                                                    Kemitraan
                                                </option>
                                                <option <?= esc($oldPenelitian["jenis"] == "Hilirisasi"? "selected": "") ?> >
                                                    Hilirisasi
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Status</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="status">
                                                <option <?= esc($oldPenelitian["status"] == "Didanai"? "selected": "")?>>
                                                    Didanai
                                                </option>
                                                <option <?= esc($oldPenelitian["status"] == "Submit Proposal"? "selected": "")?>>
                                                    Submit Proposal
                                                </option>
                                                <!-- <option>Mandiri</option>
                                                    <option>Kerjasama Perguruan Tinggi</option>
                                                    <option>Kemitraan</option>
                                                    <option>Hilirisasi</option> -->
                                            </select>
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
                                    <p class="card-title-desc">Masukan data <code>keanggotaan</code> ke dalam <code>form</code> berikut.</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Ketua Peneliti</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Ketua Peneliti" 
                                                id="Judul-Publikasi" 
                                                name="ketua"
                                                value="<?= esc($oldPenelitian["ketua_peneliti"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Anggota Peneliti 1</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Anggota Peneliti 1" 
                                                id="Judul-Publikasi" 
                                                name="anggota_1"
                                                value="<?= esc($oldPenelitian["anggota_peneliti_1"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Anggota Peneliti 2</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Anggota Peneliti 2" 
                                                id="Judul-Publikasi" 
                                                name="anggota_2"
                                                value="<?= esc($oldPenelitian["anggota_peneliti_2"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Anggota Peneliti 3</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Anggota Peneliti 3" 
                                                id="Judul-Publikasi" 
                                                name="anggota_3"
                                                value="<?= esc($oldPenelitian["anggota_peneliti_3"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Anggota Peneliti 4</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Anggota Peneliti 4" 
                                                id="Judul-Publikasi" 
                                                name="anggota_4"
                                                value="<?= esc($oldPenelitian["anggota_peneliti_4"]) ?>"
                                            >
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
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="Judul-Publikasi" 
                                                name="mitra"
                                                value="<?= esc($oldPenelitian["mitra"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">laboratorium Riset</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="Judul-Publikasi" 
                                                name="lab_riset"
                                                value="<?= esc($oldPenelitian["lab_riset"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">kesesuaian roadmap</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="Judul-Publikasi" 
                                                name="roadmap"
                                                value="<?= esc($oldPenelitian["kesesuaian_roadmap"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">catatan rekomendasi</label>
                                        <div class="col-md-10">
                                            <textarea 
                                                class="form-control" 
                                                type="text" 
                                                id="Judul-Publikasi" 
                                                name="rekomendasi"
                                                value="<?= esc($oldPenelitian["catatan_rekomendasi"]) ?>"
                                            >
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Luaran riset/abdimas</label>
                                        <div class="col-md-10"> <!-- Which column represent this? -->
                                            <select class="form-select" name="riset">
                                                <option>Riset</option>
                                                <option>Abdimas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">mata kuliah relevan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="Judul-Publikasi" 
                                                name="mk_relevan"
                                                value="<?= esc($oldPenelitian["mk_relevan"]) ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Tanggal Pengesahan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="date" 
                                                id="example-date-input" 
                                                name="tgl_pengesahan"
                                                value="<?= esc($oldPenelitian["tgl_pengesahan"]) ?>"
                                            >
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