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

<style>
    hr {
        margin-top: 2rem;
        margin-bottom: 2rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.5);
    }
</style>

<?php
    $jenisAbdimas = [ "EKSTERNAL", "INTERNAL"];
    $statusAbdimas = [ "Didanai", "Tidak didanai", "Closed", "Submit Proposal"];
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
                <form action="/admin/abdimas_save" method="post">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Input Data Abdimas</h4>
                                    <p class="card-title-desc">Masukkan data <code>abdimas</code> ke dalam <code>form</code> berikut</p>

                                    <div class="mb-3 row">
                                        <label for="Judul-Abdimas" class="col-md-2 col-form-label">
                                            Judul abdimas
                                            <span style="color: red"> * </span>
                                        </label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Judul" 
                                                id="Judul_Abdimas" 
                                                name="judul"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Nama kegiatan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Nama kegiatan" 
                                                id="Judul-Publikasi" 
                                                name="nama_kegiatan"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Tahun" class="col-md-2 col-form-label">
                                            Tahun
                                            <span style="color: red"> * </span>
                                        </label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="number" 
                                                placeholder="Tahun Abdimas" 
                                                min="1"
                                                id="Tahun" 
                                                name="tahun"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jenis" class="col-md-2 col-form-label">
                                            Jenis abdimas
                                            <span style="color: red"> * </span>
                                        </label>
                                        <div class="col-md-10">
                                            <select id="jenis" class="form-select" name="jenis">
                                                <option value=""> (Pilih jenis abdimas)</option>
                                                <?php foreach($jenisAbdimas as $jenis): ?>
                                                    <option> <?= $jenis?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label for="status" class="col-md-2 col-form-label">Status</label>
                                        <div class="col-md-10">
                                            <select id="abdimas_status" class="form-select" name="status">
                                                <option value=""> (Pilih status abdimas)</option>
                                                <?php foreach($statusAbdimas as $status): ?>
                                                    <option> <?= $status?> </option>
                                                <?php endforeach ?>
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
                                    <p class="card-title-desc">Masukkan data <code>abdimas</code> ke dalam <code>form</code> berikut.</p>
                                    <div class="mb-3 row">
                                        <label for="Ketua" class="col-md-2 col-form-label"> Ketua </label>
                                        <div class="col-md-10">
                                            <select class="form-control" list="datalistOptions" id="Ketua" placeholder="kode dosen" name="ketua">
                                                <option value=""> (Ketua eksternal) </option>
                                                <?php foreach ($listDosen as $dosen): ?>
                                                    <option value="<?=$dosen?>" > <?=$dosen?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php foreach(range(1, 8) as $nAnggota): ?>
                                        <div class="mb-3 row">
                                            <label 
                                                for="Anggota_<?=$nAnggota?>" 
                                                class="col-md-2 col-form-label"
                                            >
                                                Anggota <?=$nAnggota?>
                                            </label>

                                            <div class="col-md-10">
                                                <select class="form-control" id="Anggota_<?=$nAnggota?>" name="anggota_<?=$nAnggota?>">
                                                    <option value=""> (Kosong / anggota eksternal) </option>
                                                    <?php foreach ($listDosen as $dosen): ?>
                                                        <option value="<?=$dosen?>" > <?=$dosen?> </option>
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
                                    <p class="card-title-desc">Masukkan data <code>Abdimas</code> ke dalam <code>form</code> berikut</p>
                                    <div class="mb-3 row">
                                        <label for="Institusi_mitra" class="col-md-2 col-form-label">Institusi mitra</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Institusi Mitra" 
                                                id="Institusi_mitra" 
                                                name="mitra"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Alamat_mitra" class="col-md-2 col-form-label">Alamat mitra</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Alamat Mitra" 
                                                id="Alamat_mitra" 
                                                name="alamat_mitra"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="labRiset" class="col-md-2 col-form-label">Laboratorium riset</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Laboratorium Riset" 
                                                id="labRiset" 
                                                name="lab_riset"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="kesesuaian_roadmap" class="col-md-2 col-form-label">Kesesuaian roadmap</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Kesesuaian Roadmap" 
                                                id="kesesuaian_roadmap" 
                                                name="kesesuaian_roadmap"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="permasalahan_masyarakat" class="col-md-2 col-form-label">Permasalahan masyarakat</label>
                                        <div class="col-md-10">
                                            <!-- <input class="form-control" type="text" placeholder="Permasalahan Masyarakat" id="permasalahan_masyarakat"> -->
                                            <textarea class="form-control" id="permasalahan_masyarakat" rows="3" name="permasalahan_masy"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="solusi" class="col-md-2 col-form-label">Solusi</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder="Solusi" 
                                                id="solusi" 
                                                name="solusi"
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="catatan" class="col-md-2 col-form-label">Catatan</label>
                                        <div class="col-md-10">
                                            <!-- <input class="form-control" type="text" placeholder="Catatan" id="catatan"> -->
                                            <textarea class="form-control" id="catatan" rows="3" name="catatan"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="luaran" class="col-md-2 col-form-label">Luaran</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                placeholder= "Luaran" 
                                                id="luaran" 
                                                name="luaran"
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
                                        <label for="tanggal_pengesahan" class="col-md-2 col-form-label">Tanggal pengesahan</label>
                                        <div class="col-md-10">
                                            <input 
                                                class="form-control" 
                                                type="date" 
                                                placeholder="Tanggal Pengesahan" 
                                                id="tanggal_pengesahan" 
                                                name="tgl_pengesahan"
                                            >
                                        </div>
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
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <!-- Start Form Sizing -->
                </form>
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