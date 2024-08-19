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
    $jenisPenelitian = ["Internal",
                            "Eksternal",
                            "Mandiri",
                            "Kerjasama Perguruan Tinggi",
                            "Kemitraan",
                            "Hilirisasi" ];
    $statusPenelitian = ["Didanai", "Submit Proposal"];
    $luaranPenelitian = ["Riset", "Abdimas"];
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
                <form action="/admin/penelitian_save" method="post">
                    <?= csrf_field(); ?> <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Input Data Penelitian</h4>
                                    <p class="card-title-desc">Masukkan data <code>penelitian</code> ke dalam <code>form</code> berikut</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Judul penelitian</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Judul Penelitian" 
                                                id="Judul-Publikasi" 
                                                name="judul_penelitian"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Nama kegiatan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Nama Kegiatan" 
                                                id="nama_kegiatan" 
                                                name="nama_kegiatan"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-number-input" class="col-md-2 col-form-label">Tahun</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="number" 
                                                placeholder="Tahun Penelitian" 
                                                min="1"
                                                id="example-number-input" 
                                                name="tahun"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Jenis penelitian</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="jenis">
                                                <option value=""> (Pilih jenis penelitian)</option>
                                                <?php foreach($jenisPenelitian as $jenis): ?>
                                                    <option> <?= $jenis ?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Status</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="status">
                                                <option value=""> (Pilih status penelitian)</option>
                                                <?php foreach($statusPenelitian as $status): ?>
                                                    <option> <?= $status ?> </option>
                                                <?php endforeach; ?>
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
                                    <p class="card-title-desc">Masukkan data <code>keanggotaan</code> ke dalam <code>form</code> berikut.</p>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Ketua peneliti</label>
                                        <div class="col-md-10">
                                            <select 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Ketua Peneliti" 
                                                id="ketua_penelitian" 
                                                name="ketua_peneliti"
                                            >
                                                <option value=""> (Ketua eksternal) </option>
                                                <?php foreach ($listDosen as $dosen): ?>
                                                    <option value="<?=$dosen?>" > 
                                                        <?=$dosen?> 
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php foreach(range(1, 10) as $nAnggota): ?>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Anggota peneliti <?=$nAnggota ?> </label>
                                            <div class="col-md-10">
                                                <select 
                                                    class="form-control" 
                                                    type="text" 
                                                    placeholder="Anggota Peneliti <?= $nAnggota?>" 
                                                    id="anggota_<?=$nAnggota?>Penelitian" 
                                                    name="anggota_peneliti_<?=$nAnggota?>"
                                                    class="form-control" 
                                                >
                                                    <option value=""> (Kosong / anggota eksternal) </option>
                                                    <?php foreach ($listDosen as $dosen): ?>
                                                        <option value="<?=$dosen?>" > 
                                                            <?=$dosen?> 
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
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
                                    <p class="card-title-desc">Masukkan data <code>penelitian</code> ke dalam <code>form</code> berikut</p>

                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Institusi mitra</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="institusi_mitra" 
                                                placeholder="Nama Institusi Mitra"
                                                name="mitra"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Laboratorium riset</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="lab_riset" 
                                                placeholder="Nama Laboratorium Riset"
                                                name="lab_riset"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Kesesuaian roadmap</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="kesesuaian_roadmap">
                                                <option value=""> (Pilih roadmap) </option>
                                                <?php foreach($roadmap as $r): ?>
                                                    <option value="<?= $r["id"]?>"> <?= $r["topik"] ?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Catatan rekomendasi</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" type="text" id="Judul-Publikasi" name="catatan_rekomendasi"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label">Luaran riset/abdimas</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="luaran">
                                                <option value=""> (Pilih jenis luaran)</option>
                                                <?php foreach($luaranPenelitian as $luaran): ?>
                                                    <option> <?= $luaran ?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Mata kuliah relevan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="mk_relevan" 
                                                placeholder="Nama mata kuliah relevan"
                                                name="mk_relevan"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Tanggal pengesahan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="date" 
                                                id="example-date-input" 
                                                name="tgl_pengesahan"
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