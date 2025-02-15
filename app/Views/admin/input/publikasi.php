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

<?php
    $jenisPublikasi = [ "Jurnal Internasional",
                        "Jurnal Nasional",
                        "Prosiding Internasional",
                        "Prosiding Nasional" ];
    $akreditasiPublikasi = [ "Q1", "Q2", "Q3", "Q4", 
                            "S1", "S2", "S3", "S4", "S5", "S6",
                            "Scopus"];
?>
<!-- Begin page -->
<div id="layout-wrapper">
    <?= $this->include('partials/menu') ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif ?>
            <div class="container-fluid">
                <form action="/admin/publikasi_save">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Input Data Publikasi</h4>
                                    <p class="card-title-desc">Masukkan data <code>publikasi</code> ke dalam <code>form</code> berikut</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">
                                            Judul publikasi
                                            <span style="color: red"> * </span>
                                        </label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Judul publikasi"
                                                id="Judul-Publikasi" 
                                                name="judul_publikasi"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-md-2 col-form-label">
                                            Tahun
                                            <span style="color: red"> * </span>
                                        </label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="number" 
                                                id="example-number-input" 
                                                name="tahun"
                                                placeholder="Tahun Publikasi" 
                                                min="1"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Jenis publikasi</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="jenis">
                                                <option value=""> (Pilih jenis publikasi)</option>
                                                <?php foreach($jenisPublikasi as $jenis): ?>
                                                    <option> <?= $jenis ?> </option>
                                                <?php endforeach; ?>
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
                                    <p class="card-title-desc">Masukkan data <code>penulis</code> ke dalam <code>form</code> berikut.</p>
                                    <?php foreach(range(1, 11) as $nPenulis): ?>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Penulis <?=$nPenulis?></label>
                                            <div class="col-md-10">
                                                <select 
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="kode dosen" 
                                                    id="Judul-Publikasi" 
                                                    name="penulis_<?= $nPenulis?>"
                                                >
                                                    <?php if($nPenulis == 1): ?>
                                                        <option value=""> (Penulis eksternal) </option>
                                                    <?php else: ?>
                                                        <option value=""> (Kosong / penulis eksternal) </option>
                                                    <?php endif ?>
                                                    <?php foreach ($listDosen as $dosen): ?>
                                                        <option value="<?=$dosen?>" > 
                                                            <?=$dosen?> 
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Semua penulis</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="masukan semua penulis" 
                                                id="Judul-Publikasi" 
                                                name="penulis_all"
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
                                    <p class="card-title-desc">Masukkan data <code>publikasi</code> ke dalam <code>form</code> berikut</p>

                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Lab riset</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Lab riset" 
                                                id="labRiset" 
                                                name="lab_riset"
                                            >
                                        </div>
                                    </div>
                                    <!-- <div class="mb-3 row">
                                        <label for="targetLuaran" class="col-md-2 col-form-label">Target luaran</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder= "Target Luaran" 
                                                id="targetLuaran" 
                                                name="target_luaran"
                                            >
                                        </div>
                                    </div> -->
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Institusi mitra</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="institusi mitra" 
                                                id="Judul-Publikasi" 
                                                name="institusi_mitra"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Nama jurnal/konferensi </label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="jurnal/konferensi" 
                                                id="Judul-Publikasi" 
                                                name="nama_journal_conf"
                                            >
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label"> Peringkat jurnal</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="akreditasi_journal_conf">
                                                <option> not accredited yet </option>
                                                <?php foreach($akreditasiPublikasi as $akreditasi): ?>
                                                    <option> <?= $akreditasi ?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-url-input" class="col-md-2 col-form-label">URL artikel</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="url" 
                                                placeholder="Link Artikel" 
                                                id="example-url-input" 
                                                name="link_artikel"
                                            >
                                        </div>
                                    </div>
                                    <!-- <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Luaran riset/abdimas</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="luaran">
                                                <option>Riset</option>
                                                <option>Abdimas</option>
                                            </select>
                                        </div>
                                    </div> -->

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